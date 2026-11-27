# Build kit for `readystack/wordpress:7.1.5-CE-ubuntu24.04-r7`

This archive rebuilds the linux/amd64 image `readystack/wordpress:7.1.5-CE-ubuntu24.04-r7` from its own contents, with the network off, and checks the result against the image digest ReadyStack published, `sha256:6f413a20130bd32fc68b53773a832ba9d1f0c787adeaa9eb9671c448fdaa7bb1` (also in `TARGET_DIGEST.txt`). It holds everything the build needs, not the image itself.

Every release of this kit, its recipe and its defect issues are published at https://github.com/readystack-dev/wordpress; the product page is https://readystack.dev/products/wordpress.

## Rebuild it

You need linux/amd64 Docker with `buildx` 0.30 or later, `jq` and `tar` (docs/REBUILD.md lists the rest, if any, and the hardware ReadyStack used).

```
tar -xpzf ReadyStack-wordpress-7.1.5-CE-ubuntu24.04-r7.tar.gz    # -p keeps each file's mode
cd 7.1.5-CE-ubuntu24.04-r7
./BUILD_OFFLINE.sh            # builds with the network off, from this archive alone
./VERIFY_OFFLINE.sh           # compares the rebuilt digest with the published one, then checks the image
```

`./VERIFY_OFFLINE.sh --online` also checks that the Docker Hub tag holds the digest you rebuilt.

File modes are build input: a Dockerfile `COPY` carries them into the image. Unpacked without `-p`, your umask changes them (664 becomes 644 under umask 022). `FILE_MODES.tsv` records the mode of every file and directory as packed; `BUILD_OFFLINE.sh` puts back any that differ before it builds, and `./BUILD_OFFLINE.sh --restore-modes` does only that.

## Check ReadyStack's signature (optional)

ReadyStack signs this archive's `rebuild.json` with its release key once the finished archive has passed the release gate, and records the signature in the public Sigstore transparency log. The signature is made after the archive is sealed, so it is published beside it rather than inside it. Download it and the public key next to this directory, not into it: a file added inside the kit changes the tree hash that `rebuild.json` records, and `validate` then refuses the kit.

```
curl -fsSLo ../cosign.pub https://readystack.dev/keys/cosign.pub
curl -fsSLo ../ReadyStack-wordpress-7.1.5-CE-ubuntu24.04-r7.rebuild.json.sigstore https://readystack.dev/api/kit/wordpress/7.1.5-CE-ubuntu24.04-r7/files/ReadyStack-wordpress-7.1.5-CE-ubuntu24.04-r7.rebuild.json.sigstore
python3 docs/rebuild-bundle/rebuild_bundle.py validate . --key ../cosign.pub --signature ../ReadyStack-wordpress-7.1.5-CE-ubuntu24.04-r7.rebuild.json.sigstore
```

`validate` needs Python 3 and cosign. Without building anything it checks the signature over `rebuild.json`, every file's checksum, the tree hash over every file's path, mode and content, each base image layout's digest and the builder archive. `verify`, with the same arguments, also rebuilds with the builder's network egress blocked and exits 0 only when the rebuilt digest is the published one (docs/REBUILD.md).

## What else is here

- `docs/REBUILD.md`: the full rebuild guide: requirements, what `rebuild.json` records, the verifier's exit codes, and SLSA provenance on your own build platform
- `docs/VERIFY.md`: checking the published image, its signature and its attestations without rebuilding
- `docs/PROVENANCE.md`: where every input came from
- `docs/PINS.md`: every pinned input and why it was chosen
- `docs/RELEASE_NOTES.md`: what this release changed, and its known issues
- `docs/admin-guide/ADMIN_HANDBOOK.md`: running the product
- `TRADEMARK.md`: the product's trademark notice
