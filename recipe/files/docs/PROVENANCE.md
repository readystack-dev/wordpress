# Provenance — WordPress (`7.1.5-CE-ubuntu24.04-r7`)

Every item below is copied from a record in this archive; the record is named in brackets.

## Source

- Upstream repository: https://github.com/WordPress/WordPress
- Revision built: `7.1.5` (commit `7be93a9688cfcac7ea1c3ff00ad970ed8a47849b`)
- Source tree: `5df7fcf34f277b0e192e059d398eb9764382fa3d3c922fed6c9e658d8cd9edb0` over 5013 files [`docs/provenance/SOURCE_TREE_HASH.json`]
- Community Edition only: enterprise code is removed or refused before the build (CE audit at acquire).

## Build

- Method: `source-rebuild-php`; base image `ubuntu:24.04`
- Built with `--network=none` from vendored source, dependencies and base images; BuildKit pinned to `moby/buildkit:v0.31.2` (shipped in `toolchain/`).
- SOURCE_DATE_EPOCH: `1795670524` [`SOURCE_DATE_EPOCH.txt`]
- Frozen inputs: [`docs/provenance/FREEZE_MANIFEST.json`], build recipe: [`docs/provenance/BUILD_RECIPE.json`].

## Output

- Published image: `readystack/wordpress:7.1.5-CE-ubuntu24.04-r7` — index digest `sha256:bc021a36d761597559df1693e08a239aaa7c6ab86f17936a61ccc65b0e151321` [`docs/provenance/LOCKED_DIGEST.txt`]
- linux/amd64 image digest `sha256:6f413a20130bd32fc68b53773a832ba9d1f0c787adeaa9eb9671c448fdaa7bb1` — reproduced from this archive before publishing [`docs/provenance/REPRO_VERIFICATION.json`].

## Attestations and signature

- SBOM + SLSA provenance attached to the image: attached: an SPDX SBOM and SLSA v1 provenance [`docs/provenance/SCOUT_VERDICT.json`]
- cosign signature by the ReadyStack release key: verified before publishing. Check it: `cosign verify --key https://readystack.dev/keys/cosign.pub readystack/wordpress:7.1.5-CE-ubuntu24.04-r7`

## Pinned inputs, and why

- 32 pinned inputs, each with where it came from, why this one, how it was checked and when it was decided: `docs/PINS.md` [`docs/provenance/PINS.json`] (upstream source 2, base and build images 1, image digests 1, language runtimes and toolchains 1, dependency versions readystack sets 20, components from other repositories 1, pins in the kit's dockerfiles 3, readystack's build engine 1, dependencies upstream chose 2).

## Build trail

- How this release passed through the ReadyStack harness, record by record (every chain, drive, stage, review round, defect and check, each naming the record it is copied from): `ReadyStack-wordpress-7.1.5-CE-ubuntu24.04-r7.trail.json`, published beside this archive and signed with the release key (`ReadyStack-wordpress-7.1.5-CE-ubuntu24.04-r7.trail.json.sigstore`), and readable at https://readystack.dev/products/wordpress/trail/7.1.5-CE-ubuntu24.04-r7.

