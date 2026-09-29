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
args.add_argument('--mode', choices=['sequence','hero','detail','living','materials','front','placement','setup','wood','metal','fabric'], default='sequence')
args.add_argument('--frame', type=int)
opts = args.parse_args(sys.argv[sys.argv.index('--') + 1:] if '--' in sys.argv else [])
HERE = os.path.dirname(os.path.abspath(__file__))
OUT = os.path.abspath(os.path.join(HERE, '../../../../../output/seven-onepages-20260929/aura-renders'))
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

walnut = material('Oiled American walnut', (.08, .034, .012), rough=.36)
nodes, links = walnut.node_tree.nodes, walnut.node_tree.links
coord = nodes.new('ShaderNodeTexCoord')
wood = nodes.new('ShaderNodeTexImage')
wood.image = bpy.data.images.load(os.path.join(HERE, 'aura-walnut-albedo.png'))
wood.projection='BOX';wood.projection_blend=.18
links.new(coord.outputs['Generated'], wood.inputs['Vector'])
tone = nodes.new('ShaderNodeHueSaturation');tone.inputs['Saturation'].default_value=1.25;tone.inputs['Value'].default_value=.55
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
metal = material('Satin brushed champagne aluminum', (.45, .32, .17), .87, .29)
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
camera=bpy.context.object;aim(camera,(0,0,1.12));camera.data.type='ORTHO';camera.data.ortho_scale=4.85
scene=bpy.context.scene;scene.camera=camera;scene.render.engine='CYCLES'
scene.cycles.samples=32 if opts.preview else 64;scene.cycles.use_denoising=True
scene.render.resolution_x=1080;scene.render.resolution_y=810;scene.render.resolution_percentage=100
scene.render.image_settings.file_format='PNG';scene.world.color=(.045,.039,.03)
scene.view_settings.view_transform='AgX';scene.view_settings.look='AgX - Medium High Contrast';scene.view_settings.exposure=-.3;scene.render.film_transparent=True
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
scene.frame_set(opts.frame or 1)
# All editorial scenes use this exact assembly, materials, knob and rear connector geometry.
# Only cameras, lighting and the explicitly named environment change between deliverables.
def environment_box(name, pos, size, mat, bevel=.03):
    obj=box(name,pos,size,mat,bevel);obj.parent=None;return obj
sand=material('Honed limestone',(.46,.39,.30),rough=.82)
nodes,links=sand.node_tree.nodes,sand.node_tree.links
noise=nodes.new('ShaderNodeTexNoise');noise.inputs['Scale'].default_value=85
bump=nodes.new('ShaderNodeBump');bump.inputs['Strength'].default_value=.22;bump.inputs['Distance'].default_value=.025
links.new(noise.outputs['Fac'],bump.inputs['Height']);links.new(bump.outputs[0],nodes.get('Principled BSDF').inputs['Normal'])
cream=material('Warm plaster',(.39,.34,.27),rough=.95)
paper=material('Book ivory',(.65,.58,.47),rough=.9)
linen=material('Linen book cloth',(.16,.12,.065),rough=.85)
for x in [-1.15,1.15]:
    for y in [-.42,.42]:cylinder('Recessed foot',(x,y,.073),.12,.1,rubber)
if opts.mode!='sequence':
    root.animation_data_clear();root.rotation_euler[2]=0
    scene.render.film_transparent=False
    scene.render.resolution_x=1600;scene.render.resolution_y=1200
    environment_box('Stone console',(0,0,-.20),(18,12,.46),sand,.045)
    environment_box('Plaster wall',(0,4,4),(25,.2,9),cream,0)
    camera.data.type='PERSP';camera.data.lens=52
    camera.location=(4.5,-8,4.6);aim(camera,(0,0,1.02))
    if opts.mode=='hero':
        camera.location=(4.1,-7.6,3.7);aim(camera,(0,0,1.04));camera.data.lens=56
    elif opts.mode=='detail':
        camera.location=(2.4,-3.1,3.9);aim(camera,(.88,-.21,2.04));camera.data.lens=76
    elif opts.mode=='materials':
        camera.location=(-3.3,-4.2,2.6);aim(camera,(-1.17,-.50,1.38));camera.data.lens=84
    elif opts.mode=='wood':
        camera.location=(4.3,-1.0,2.3);aim(camera,(1.57,-.20,1.3));camera.data.lens=78
    elif opts.mode=='metal':
        camera.location=(2.0,-2.6,4.1);aim(camera,(1.0,-.08,2.32));camera.data.lens=105
    elif opts.mode=='fabric':
        camera.location=(.4,-4.0,1.8);aim(camera,(.2,-.74,1.48));camera.data.lens=100
    elif opts.mode=='front':
        camera.data.type='ORTHO';camera.data.ortho_scale=4.65;camera.location=(0,-8,1.35);aim(camera,(0,0,1.2))
    elif opts.mode in ['placement','setup','living']:
        # The same walnut object sits on a physical shelf, with independent book/vase arrangements.
        scene.render.resolution_x=1800;scene.render.resolution_y=1200
        environment_box('Walnut console face',(0,.1,-.55),(9,2.9,.65),walnut,.05)
        environment_box('Console leg left',(-3.5,.1,-1.35),(.2,2.4,1.2),black,.03)
        environment_box('Console leg right',(3.5,.1,-1.35),(.2,2.4,1.2),black,.03)
        for i in range(3):environment_box('Clothbound book '+str(i),(-2.75,-.1,.12+i*.16),(1.0,1.10,.12),paper if i%2 else linen,.01)
        bpy.ops.mesh.primitive_uv_sphere_add(segments=48,ring_count=24,location=(2.7,.55,.55))
        vase=bpy.context.object;vase.name='Stoneware vessel';vase.scale=(.4,.4,.65);vase.data.materials.append(sand)
        bpy.ops.mesh.primitive_cylinder_add(vertices=48,radius=.13,depth=.55,location=(2.7,.55,1.16));bpy.context.object.data.materials.append(sand)
        if opts.mode=='living':
            camera.location=(6.4,-12,5.6);aim(camera,(0,.3,.9));camera.data.lens=46
            for i in range(5):environment_box('Wall acoustic slat '+str(i),(-6+i*.4,3.7,2),(0.1,.14,7),walnut,.02)
        elif opts.mode=='placement':
            camera.location=(.3,-10,7);aim(camera,(0,.25,.9));camera.data.lens=47
        else:
            root.rotation_euler[2]=math.radians(145)
            camera.location=(4.7,-9,4.6);aim(camera,(-.35,.4,1.08));camera.data.lens=46
            bpy.data.objects['Plaster wall'].location.y=2.3
            for obj in bpy.data.objects:
                if obj.name.startswith('Clothbound book'):obj.hide_render=True
            # Curved rear cable has physical thickness and lands at a wall socket.
            cu=bpy.data.curves.new('Power cable','CURVE');cu.dimensions='3D';cu.bevel_depth=.022;cu.bevel_resolution=3
            sp=cu.splines.new('BEZIER');sp.bezier_points.add(4)
            for pt,co in zip(sp.bezier_points,[(-.5,-.62,.63),(-1.0,-.85,.18),(-3.1,.65,.18),(-4.15,1.75,.48),(-4.15,2.13,1.03)]):pt.co=co;pt.handle_left_type='FREE';pt.handle_right_type='FREE'
            pts=list(sp.bezier_points)
            for i,pt in enumerate(pts):
                tangent=(pts[min(i+1,len(pts)-1)].co-pts[max(i-1,0)].co)/6
                pt.handle_left=pt.co-tangent;pt.handle_right=pt.co+tangent
                pt.handle_left.z=max(.14,pt.handle_left.z);pt.handle_right.z=max(.14,pt.handle_right.z)
            ob=bpy.data.objects.new('Rear power lead',cu);bpy.context.collection.objects.link(ob);ob.data.materials.append(black)
            environment_box('Power outlet',(-4.15,2.17,1.03),(.46,.08,.60),paper,.035)
            socket=cylinder('Socket face',(-4.15,2.115,1.03),.12,.04,black,(math.pi/2,0,0));socket.parent=None
            plug=cylinder('Power plug',(-4.15,2.075,1.03),.074,.10,black,(math.pi/2,0,0));plug.parent=None
    scene.render.filepath=os.path.join(OUT,'aura-'+opts.mode+'.png')
    bpy.ops.render.render(write_still=True)
elif opts.preview or opts.frame:
    scene.render.filepath=os.path.join(OUT,'preview.png' if opts.preview else 'aura-%04d.png'%opts.frame)
    bpy.ops.render.render(write_still=True)
else:
    bpy.ops.file.pack_all()
    bpy.ops.wm.save_as_mainfile(filepath=os.path.join(HERE,'aura-concept.blend'))
    scene.render.filepath=os.path.join(OUT,'aura-');bpy.ops.render.render(animation=True)
