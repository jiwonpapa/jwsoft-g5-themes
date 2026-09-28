"""JW SOFT authored AURA concept. Blender offline only; no customer runtime dependency.

blender -b -t 8 --python render-aura.py -- --preview
blender -b -t 8 --python render-aura.py
"""
import argparse
import math
import os
import sys
import bpy
from mathutils import Vector

args = argparse.ArgumentParser()
args.add_argument('--preview', action='store_true')
opts = args.parse_args(sys.argv[sys.argv.index('--') + 1:] if '--' in sys.argv else [])
HERE = os.path.dirname(os.path.abspath(__file__))
OUT = os.path.abspath(os.path.join(HERE, '../../../../../output/qa/aura-renders'))
os.makedirs(OUT, exist_ok=True)
bpy.ops.object.select_all(action='SELECT')
bpy.ops.object.delete(use_global=False)

def material(name, color, metal=0, rough=.4):
    mat = bpy.data.materials.new(name)
    mat.use_nodes = True
    mat.node_tree.nodes.clear()
    shader = mat.node_tree.nodes.new('ShaderNodeBsdfPrincipled')
    shader.name = 'Principled BSDF'
    output = mat.node_tree.nodes.new('ShaderNodeOutputMaterial')
    mat.node_tree.links.new(shader.outputs['BSDF'], output.inputs['Surface'])
    shader.inputs['Base Color'].default_value = (*color, 1)
    shader.inputs['Metallic'].default_value = metal
    shader.inputs['Roughness'].default_value = rough
    return mat

walnut = material('Oiled American walnut', (.08, .034, .012), rough=.72)
nodes, links = walnut.node_tree.nodes, walnut.node_tree.links
coord = nodes.new('ShaderNodeTexCoord')
wood = nodes.new('ShaderNodeTexImage')
wood.image = bpy.data.images.load(os.path.join(HERE, 'aura-walnut-albedo.png'))
wood.projection='BOX';wood.projection_blend=.18
links.new(coord.outputs['Generated'], wood.inputs['Vector'])
tone = nodes.new('ShaderNodeHueSaturation');tone.inputs['Saturation'].default_value=.85;tone.inputs['Value'].default_value=.7
links.new(wood.outputs['Color'],tone.inputs['Color'])
links.new(tone.outputs['Color'],nodes.get('Principled BSDF').inputs['Base Color'])
bump = nodes.new('ShaderNodeBump');bump.inputs['Strength'].default_value=.18;bump.inputs['Distance'].default_value=.002
links.new(wood.outputs['Color'],bump.inputs['Height'])
links.new(bump.outputs[0],nodes.get('Principled BSDF').inputs['Normal'])

fabric = material('Woven charcoal acoustic textile', (.037, .039, .038), rough=.88)
nodes, links = fabric.node_tree.nodes, fabric.node_tree.links
coord = nodes.new('ShaderNodeTexCoord')
waves = []
for direction in ('X', 'Z'):
    wave = nodes.new('ShaderNodeTexWave'); wave.bands_direction = direction
    wave.inputs['Scale'].default_value = 35
    wave.inputs['Distortion'].default_value = .12
    links.new(coord.outputs['Generated'], wave.inputs['Vector']); waves.append(wave)
tex = nodes.new('ShaderNodeMath'); tex.operation = 'MULTIPLY'
links.new(waves[0].outputs['Fac'],tex.inputs[0]);links.new(waves[1].outputs['Fac'],tex.inputs[1])
shade = nodes.new('ShaderNodeValToRGB')
shade.color_ramp.elements[0].color=(.006,.007,.007,1)
shade.color_ramp.elements[1].color=(.034,.036,.035,1)
links.new(tex.outputs[0],shade.inputs[0]);links.new(shade.outputs[0],nodes.get('Principled BSDF').inputs['Base Color'])
bump = nodes.new('ShaderNodeBump'); bump.inputs['Strength'].default_value = .45
bump.inputs['Distance'].default_value = .007
links.new(tex.outputs[0], bump.inputs['Height'])
links.new(bump.outputs[0], nodes.get('Principled BSDF').inputs['Normal'])
metal = material('Satin brushed champagne aluminum', (.40, .34, .25), .83, .42)
# Fine directional roughness keeps the top plate aligned with the photographed concept.
nodes, links = metal.node_tree.nodes, metal.node_tree.links
coord = nodes.new('ShaderNodeTexCoord')
grains = nodes.new('ShaderNodeVectorMath'); grains.operation='MULTIPLY';grains.inputs[1].default_value=(1,35,1)
links.new(coord.outputs['Generated'],grains.inputs[0])
noise = nodes.new('ShaderNodeTexNoise');noise.inputs['Scale'].default_value=120
links.new(grains.outputs[0],noise.inputs['Vector'])
bump = nodes.new('ShaderNodeBump');bump.inputs['Strength'].default_value=.12;bump.inputs['Distance'].default_value=.002
links.new(noise.outputs['Fac'],bump.inputs['Height']);links.new(bump.outputs[0],nodes.get('Principled BSDF').inputs['Normal'])
black = material('Recessed charcoal polymer', (.014, .015, .014), .05, .58)
rubber = material('Isolation feet', (.018, .018, .016), rough=.85)
label = material('Etched lettering', (.29, .25, .18), .5, .4)
root = bpy.data.objects.new('AURA 01 complete assembly', None)
bpy.context.collection.objects.link(root)

def box(name, pos, size, mat, bevel=.04):
    bpy.ops.mesh.primitive_cube_add(size=1, location=pos)
    obj = bpy.context.object; obj.name = name; obj.dimensions = size
    bpy.ops.object.transform_apply(location=False, rotation=False, scale=True)
    obj.data.materials.append(mat)
    if bevel:
        mod = obj.modifiers.new('Soft machined edge', 'BEVEL'); mod.width = bevel; mod.segments = 8
        obj.modifiers.new('Weighted normals', 'WEIGHTED_NORMAL')
    obj.parent = root
    return obj

def cylinder(name, pos, radius, depth, mat, rotation=(0,0,0)):
    bpy.ops.mesh.primitive_cylinder_add(vertices=96, radius=radius, depth=depth, location=pos, rotation=rotation)
    obj = bpy.context.object; obj.name = name; obj.data.materials.append(mat)
    for face in obj.data.polygons: face.use_smooth = True
    mod = obj.modifiers.new('Turned edge', 'BEVEL'); mod.width=.012; mod.segments=3
    obj.modifiers.new('Weighted normals', 'WEIGHTED_NORMAL'); obj.parent=root
    return obj

def rounded_panel(name, center, width, height, depth, radius, mat):
    outline=[]
    for cx,cz,start in [(width/2-radius,height/2-radius,0),(-width/2+radius,height/2-radius,90),(-width/2+radius,-height/2+radius,180),(width/2-radius,-height/2+radius,270)]:
        for step in range(17):
            angle=math.radians(start+step*90/16)
            outline.append((cx+radius*math.cos(angle),cz+radius*math.sin(angle)))
    n=len(outline)
    verts=[(x+center[0],center[1]+y,z+center[2]) for y in (-depth/2,depth/2) for x,z in outline]
    faces=[tuple(range(n-1,-1,-1)),tuple(range(n,2*n))]+[(i,(i+1)%n,(i+1)%n+n,i+n) for i in range(n)]
    mesh=bpy.data.meshes.new(name);mesh.from_pydata(verts,[],faces);mesh.update()
    obj=bpy.data.objects.new(name,mesh);bpy.context.collection.objects.link(obj);obj.data.materials.append(mat);obj.parent=root
    bevel=obj.modifiers.new('Soft textile edge','BEVEL');bevel.width=.005;bevel.segments=3
    obj.modifiers.new('Weighted normals','WEIGHTED_NORMAL')
    return obj

box('Continuous walnut cabinet', (0,0,1.14), (3.2,1.4,2.12), walnut, .20)
box('Inset rear aluminum', (0,.701,1.14), (2.8,.035,1.70), metal, .11)
rounded_panel('Dark perimeter seam',(0,-.696,1.14),2.99,1.94,.06,.19,black)
rounded_panel('Acoustic fabric front',(0,-.733,1.14),2.95,1.90,.045,.18,fabric)
box('Precision top plate', (0,-.005,2.205), (2.87,1.14,.055), metal, .11)
cylinder('Dial black gasket', (1.00,-.08,2.251), .236,.034,black)
cylinder('Knurled volume dial', (1.00,-.08,2.327), .222,.13,metal)
for index in range(80):
    theta=index*math.tau/80
    cylinder('Dial knurl', (1+.222*math.cos(theta),-.08+.222*math.sin(theta),2.322), .0048,.085,metal)
box('Dial index', (1,-.225,2.396), (.015,.075,.002), black,.003)
box('Rear connector recess', (0,.73,.63), (1.7,.025,.36), black,.025)
for x in (-.51,0,.51):
    cylinder('Rear connection ring', (x,.757,.64), .068,.02,metal,(math.pi/2,0,0))
    cylinder('Rear connection aperture', (x,.77,.64), .045,.02,black,(math.pi/2,0,0))
floor = material('Warm studio backdrop',(.055,.051,.044),rough=.58)
bpy.ops.mesh.primitive_plane_add(size=200, location=(0,0,.001))
bpy.context.object.data.materials.append(floor)
bpy.context.object.hide_render=True # A truly empty alpha ground works on every theme color.
def aim(obj,point): obj.rotation_euler=(Vector(point)-obj.location).to_track_quat('-Z','Y').to_euler()
for name,loc,power,size in [('Large left softbox',(-4,-4,7),1250,5),('Edge strip',(3,3,5),1700,4),('Front fill',(2,-5,3),350,4)]:
    light=bpy.data.lights.new(name,'AREA'); light.energy=power; light.shape='DISK';light.size=size
    obj=bpy.data.objects.new(name,light);bpy.context.collection.objects.link(obj);obj.location=loc;aim(obj,(0,0,1))
bpy.ops.object.camera_add(location=(4,-8,4.2))
camera=bpy.context.object;aim(camera,(0,0,1.12));camera.data.type='ORTHO';camera.data.ortho_scale=5.3
scene=bpy.context.scene;scene.camera=camera;scene.render.engine='CYCLES'
scene.cycles.samples=32 if opts.preview else 48;scene.cycles.use_denoising=True
scene.render.resolution_x=1080;scene.render.resolution_y=810;scene.render.resolution_percentage=100
scene.render.image_settings.file_format='PNG';scene.world.color=(.16,.16,.16)
scene.view_settings.view_transform='AgX';scene.render.film_transparent=True
scene.render.image_settings.color_mode='RGBA'
scene.frame_start=1;scene.frame_end=60
root.rotation_euler[2]=math.radians(-12);root.keyframe_insert(data_path='rotation_euler',frame=1)
root.rotation_euler[2]=math.radians(342);root.keyframe_insert(data_path='rotation_euler',frame=60)
for action in bpy.data.actions:
    for layer in action.layers:
        for strip in layer.strips:
            for bag in strip.channelbags:
                for curve in bag.fcurves:
                    for key in curve.keyframe_points: key.interpolation='LINEAR'
scene.frame_set(1)
if opts.preview:
    scene.render.filepath=os.path.join(OUT,'preview.png');bpy.ops.render.render(write_still=True)
else:
    bpy.ops.file.pack_all()
    bpy.ops.wm.save_as_mainfile(filepath=os.path.join(HERE,'aura-concept.blend'))
    scene.render.filepath=os.path.join(OUT,'aura-');bpy.ops.render.render(animation=True)
