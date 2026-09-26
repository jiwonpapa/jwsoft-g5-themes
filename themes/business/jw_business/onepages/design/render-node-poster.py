"""JW SOFT — high-quality still of the SAME model used in the scroll sequence."""
import bpy
import os
HERE = os.path.dirname(os.path.abspath(__file__))
bpy.ops.wm.open_mainfile(filepath=os.path.join(HERE, 'node-concept.blend'))
scene = bpy.context.scene
scene.frame_set(12)
scene.cycles.samples = 96
scene.render.resolution_x = 1536
scene.render.resolution_y = 1024
scene.render.filepath = os.path.join(HERE, 'renders', 'node-poster.png')
bpy.ops.render.render(write_still=True)
