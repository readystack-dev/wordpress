# Provenance — WordPress (`7.1.5-CE-ubuntu24.04-r6`)

Every item below is copied from a record in this archive; the record is named in brackets.

## Source

- Upstream repository: https://github.com/WordPress/WordPress
- Revision built: `7.1.5` (commit `7be93a9688cfcac7ea1c3ff00ad970ed8a47849b`)
- Source tree: `5df7fcf34f277b0e192e059d398eb9764382fa3d3c922fed6c9e658d8cd9edb0` over 5013 files [`docs/provenance/SOURCE_TREE_HASH.json`]
- Community Edition only: enterprise code is removed or refused before the build (CE audit at acquire).

## Build

- Method: `source-rebuild-php`; base image `ubuntu:24.04`
- Built with `--network=none` from vendored source, dependencies and base images; BuildKit pinned to `moby/buildkit:v0.31.2` (shipped in `toolchain/`).
- SOURCE_DATE_EPOCH: `1795644316` [`SOURCE_DATE_EPOCH.txt`]
- Frozen inputs: [`docs/provenance/FREEZE_MANIFEST.json`], build recipe: [`docs/provenance/BUILD_RECIPE.json`].

## Output

- Published image: `readystack/wordpress:7.1.5-CE-ubuntu24.04-r6` — index digest `sha256:36f2a773b339455faf5c492fd573c80f06979fa16aa22a81d159e102f1a3b396` [`docs/provenance/LOCKED_DIGEST.txt`]
- linux/amd64 image digest `sha256:e94ad90b14151644950c33db33fe845b979212fd21fe628c12c36a9ddb3f6975` — reproduced from this archive before publishing [`docs/provenance/REPRO_VERIFICATION.json`].

## Attestations and signature

- SBOM + SLSA provenance attached to the image: attached: an SPDX SBOM and SLSA v1 provenance [`docs/provenance/SCOUT_VERDICT.json`]
- cosign signature by the ReadyStack release key: verified before publishing. Check it: `cosign verify --key https://readystack.dev/keys/cosign.pub readystack/wordpress:7.1.5-CE-ubuntu24.04-r6`

## Pinned inputs, and why

- 28 pinned inputs, each with where it came from, why this one, how it was checked and when it was decided: `docs/PINS.md` [`docs/provenance/PINS.json`] (upstream source 2, base and build images 1, image digests 1, language runtimes and toolchains 1, dependency versions readystack sets 16, components from other repositories 1, pins in the kit's dockerfiles 3, readystack's build engine 1, dependencies upstream chose 2).

## Build trail

- How this release passed through the ReadyStack harness, record by record (every chain, drive, stage, review round, defect and check, each naming the record it is copied from): `ReadyStack-wordpress-7.1.5-CE-ubuntu24.04-r6.trail.json`, published beside this archive and signed with the release key (`ReadyStack-wordpress-7.1.5-CE-ubuntu24.04-r6.trail.json.sigstore`), and readable at https://readystack.dev/products/wordpress/trail/7.1.5-CE-ubuntu24.04-r6.

