# Impeccable

- Source: <https://github.com/pbakaus/impeccable>
- Skill release: `skill-v4.3.1`
- Source commit: `2361d593aaa28496557e690fffa897592c235306`
- License: Apache-2.0
- Installed scope: project-local Codex skill

The project vendors the Codex skill files only. The automatic Codex hook is not installed. The detector engine is version `0.1.5` and is downloaded to the developer cache by the vendored launcher only when the detector is run; the launcher verifies the upstream SHA-256 sidecar before execution.

Local policy disables optional telemetry through `tools/impeccable` and treats detector findings as advisory until they are calibrated against real G5 themes.
