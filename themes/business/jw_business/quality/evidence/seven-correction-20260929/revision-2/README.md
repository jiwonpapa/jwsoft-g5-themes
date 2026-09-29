# Final correction evidence — revision 2

Global source digest: `609ca656197948ad78fe9b782faa7e391b70defe57249f559c272ce0ee0ba010`.
Frozen at 2026-09-29T02:58:23Z; office Ubuntu deployment checksum matched all 15 sync targets.

- `home.pending.json` / `onepage.pending.json`: schema v2 group digests; intentionally different from the global digest. These are pending capture packets, never approvals.
- Page directories: automated full-page captures with original metadata, 8 configured desktop/mobile/theme states per page (56 total).
- `iab`: actual in-app-browser browsing, core 28 views, section crops, original screenshots and extra hero/gallery/product angle/tab views. See collection-path-note.md for a collector directory correction; capture timestamps and PNG bytes were preserved.
- `signatures`: 18 environments × 3 narrative stages; collection is not visual approval.
- `interactions`: 40 required interactions. `rotation`: 8 rotation/fallback records. `pause`: actual G5 persistent-pause regression.
- `risks`: 360/430px additional mobile states.
- `logs`: real build, style, stack, UI56 and clean generated-build checks.
- `file-checksums.json`: byte integrity of evidence files present at packaging time.

Authoritative visual judgment: docs/reports/seven-independent-review-revision-2-2026-09-29.json. Main2 wide-layout remains a failure; do not convert technical passes into whole-product acceptance. Prior revisions are historical only.
