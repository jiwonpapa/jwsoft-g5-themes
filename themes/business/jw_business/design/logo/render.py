"""Offline logo authoring only; Blender is never a website/build requirement."""
from pathlib import Path
from math import radians
import bpy
from mathutils import Vector

ROOT = Path(__file__).resolve().parents[2]
OUTPUT = ROOT.parents[2] / "output/blender/jw-business-logo"
OUTPUT.mkdir(parents=True, exist_ok=True)
bpy.ops.object.select_all(action="SELECT")
bpy.ops.object.delete(use_global=False)
scene = bpy.context.scene
scene.render.engine = "CYCLES"
scene.cycles.samples = 24
scene.cycles.use_denoising = True
scene.render.resolution_x = 648
scene.render.resolution_y = 120
scene.render.resolution_percentage = 100
scene.render.film_transparent = True
scene.render.image_settings.file_format = "PNG"
scene.render.image_settings.color_mode = "RGBA"
scene.view_settings.view_transform = "Standard"
scene.world.color = (0.35, 0.35, 0.35)

def material(name, color, metallic):
    mat = bpy.data.materials.new(name)
    mat.use_nodes = True
    mat.node_tree.nodes.clear()
    shader = mat.node_tree.nodes.new("ShaderNodeBsdfPrincipled")
    shader.name = "JW Surface"
    output = mat.node_tree.nodes.new("ShaderNodeOutputMaterial")
    mat.node_tree.links.new(shader.outputs["BSDF"], output.inputs["Surface"])
    shader.inputs["Base Color"].default_value = (*color, 1)
    shader.inputs["Metallic"].default_value = metallic
    shader.inputs["Roughness"].default_value = 0.3
    return mat

ink = material("Theme surface ink", (0.015, 0.022, 0.045), 0.1)
blue = material("JW blue enamel", (0.008, 0.19, 0.43), 0.35)
font = bpy.data.fonts.load(str(ROOT / "node_modules/pretendard/dist/public/static/Pretendard-Bold.otf"))
curve = bpy.data.curves.new("JW-Business lettering", "FONT")
curve.body = "JW-Business"
curve.font = font
curve.align_x = "CENTER"
curve.align_y = "CENTER"
curve.extrude = 0.065
curve.bevel_depth = 0.009
curve.bevel_resolution = 3
curve.materials.append(ink)
curve.materials.append(blue)
for char in curve.body_format[:3]:
    char.material_index = 1
logo = bpy.data.objects.new("JW-Business", curve)
scene.collection.objects.link(logo)
bpy.context.view_layer.update()
width = logo.dimensions.x

bpy.ops.object.camera_add(location=(0, 0, 15))
camera = bpy.context.object
camera.data.type = "ORTHO"
camera.data.ortho_scale = width * 1.075
scene.camera = camera

def area(name, location, energy, size):
    bpy.ops.object.light_add(type="AREA", location=location)
    light = bpy.context.object
    light.name = name
    light.data.energy = energy
    light.data.shape = "DISK"
    light.data.size = size
    light.rotation_euler = (Vector((0, 0, 0)) - light.location).to_track_quat("-Z", "Y").to_euler()

area("Soft key", (-3, 4, 6), 450, 5)
area("Edge highlight", (4, -1, 4), 280, 3)
for variant, color in [("light", (0.015, 0.022, 0.045)), ("dark", (0.82, 0.87, 0.95))]:
    ink.node_tree.nodes.get("JW Surface").inputs["Base Color"].default_value = (*color, 1)
    blue_color = (0.008, 0.19, 0.43) if variant == "light" else (0.08, 0.45, 0.85)
    blue.node_tree.nodes.get("JW Surface").inputs["Base Color"].default_value = (*blue_color, 1)
    for frame in range(9):
        progress = frame / 8
        logo.rotation_euler = (radians(6 + progress * 8), radians(-5 + progress * 18), 0)
        scene.render.filepath = str(OUTPUT / f"{variant}-{frame:02d}.png")
        bpy.ops.render.render(write_still=True)
logo.rotation_euler = (radians(6), radians(-5), 0)
bpy.ops.file.pack_all()
bpy.ops.wm.save_as_mainfile(filepath=str(ROOT / "design/logo/jw-business.blend"))
