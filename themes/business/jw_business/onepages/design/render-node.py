"""JW SOFT — authored demo model; Blender 5.2 background render, no runtime dependency."""
import bpy
import math
import os
from mathutils import Vector

HERE = os.path.dirname(os.path.abspath(__file__))
OUTPUT = os.path.join(HERE, "renders")
os.makedirs(OUTPUT, exist_ok=True)
bpy.ops.object.select_all(action='SELECT')
bpy.ops.object.delete(use_global=False)

def material(name, color, metal=0, rough=.4):
    mat = bpy.data.materials.new(name)
    mat.diffuse_color = (*color, 1)
    mat.use_nodes = True
    shader = mat.node_tree.nodes.get('Principled BSDF')
    shader.inputs['Base Color'].default_value = (*color, 1)
    shader.inputs['Metallic'].default_value = metal
    shader.inputs['Roughness'].default_value = rough
    return mat

silver = material('Machined aluminum', (.44, .48, .52), .85, .29)
graphite = material('Graphite face', (.024, .032, .043), .55, .32)
black = material('Port interiors', (.006, .009, .012), .1, .4)
blue = material('USB interior', (.016, .16, .32), .2)
light = material('Status light', (.02, .65, .8), .1)
shader = light.node_tree.nodes.get('Principled BSDF')
shader.inputs['Emission Color'].default_value = (.01, .6, .85, 1)
shader.inputs['Emission Strength'].default_value = 2
root = bpy.data.objects.new('NODE concept', None)
bpy.context.collection.objects.link(root)

def box(name, location, scale, mat, bevel=.045):
    bpy.ops.mesh.primitive_cube_add(size=1, location=location)
    obj = bpy.context.object
    obj.name = name
    obj.dimensions = scale
    bpy.ops.object.transform_apply(location=False, rotation=False, scale=True)
    obj.data.materials.append(mat)
    if bevel:
        mod = obj.modifiers.new('Machined edge', 'BEVEL')
        mod.width = bevel
        mod.segments = 3
        obj.modifiers.new('Weighted normals', 'WEIGHTED_NORMAL')
    obj.parent = root
    return obj

box('Aluminum enclosure', (0, 0, .71), (3.5, 2.4, 1.12), silver, .09)
box('Front plate', (0, -1.215, .7), (3.27, .08, .91), graphite)
box('Back plate', (0, 1.215, .7), (3.27, .08, .91), graphite)
for i in range(18):
    box('Cooling fin', (-1.6+i*3.2/17, 0, 1.32), (.075, 2.23, .19), silver, .02)
for x in (-1.35, 1.35):
    for y in (-.9, .9):
        box('Rubber foot', (x, y, .1), (.3, .35, .15), black, .035)
for x in (-.32, .43):
    box('Network housing', (x, -1.27, .72), (.54, .055, .42), silver, .02)
    box('Network port', (x, -1.305, .72), (.43, .023, .31), black, .006)
    for pin in range(8):
        box('Network contact', (x-.135+pin*.038, -1.324, .63), (.015, .012, .05), silver, .002)
for z in (.5, .85):
    box('USB socket', (-1.04, -1.27, z), (.46, .055, .2), silver, .015)
    box('USB tongue', (-1.04, -1.305, z), (.35, .02, .09), blue, .005)
box('Display connector', (1.13, -1.27, .7), (.41, .05, .2), black, .03)
box('Indicator', (-1.49, -1.274, .7), (.065, .028, .065), light, .024)
for x in (-1.49, 1.49):
    for z in (.36, 1.04):
        bpy.ops.mesh.primitive_cylinder_add(vertices=24, radius=.038, depth=.025, location=(x,-1.28,z), rotation=(math.pi/2,0,0))
        bpy.context.object.data.materials.append(silver)
        bpy.context.object.parent=root

ground = material('Studio floor', (.009, .012, .017), .12, .48)
bpy.ops.mesh.primitive_plane_add(size=200, location=(0,0,0))
bpy.context.object.data.materials.append(ground)

def aim(obj, point):
    obj.rotation_euler = (Vector(point)-obj.location).to_track_quat('-Z','Y').to_euler()

for name, loc, power, size in [('Key',(-4,-4,7),1600,5), ('Rim',(4,3,5),2000,4), ('Fill',(1,-5,3),650,4)]:
    data=bpy.data.lights.new(name, 'AREA')
    data.energy=power
    data.shape='DISK'
    data.size=size
    obj=bpy.data.objects.new(name,data)
    bpy.context.collection.objects.link(obj)
    obj.location=loc
    aim(obj,(0,0,.6))
bpy.ops.object.camera_add(location=(5,-8,5))
camera=bpy.context.object
aim(camera,(0,0,.72))
camera.data.type='ORTHO'
camera.data.ortho_scale=5.7
scene=bpy.context.scene
scene.camera=camera
scene.render.engine='CYCLES'
scene.cycles.samples=24
scene.cycles.use_denoising=True
scene.render.resolution_x=960
scene.render.resolution_y=640
scene.render.resolution_percentage=100
scene.render.image_settings.file_format='PNG'
scene.world.color=(.12,.12,.12)
scene.view_settings.view_transform='AgX'
scene.render.film_transparent=False
scene.frame_start=1
scene.frame_end=36
root.rotation_euler[2]=math.radians(-32)
root.keyframe_insert(data_path='rotation_euler',frame=1)
root.rotation_euler[2]=math.radians(48)
root.keyframe_insert(data_path='rotation_euler',frame=36)
for action in bpy.data.actions:
    for layer in action.layers:
        for strip in layer.strips:
            for bag in strip.channelbags:
                for curve in bag.fcurves:
                    for key in curve.keyframe_points:
                        key.interpolation='LINEAR'
scene.render.filepath=os.path.join(OUTPUT,'node-')
bpy.ops.wm.save_as_mainfile(filepath=os.path.join(HERE,'node-concept.blend'))
bpy.ops.render.render(animation=True)
