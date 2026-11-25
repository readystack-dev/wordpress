# WordPress: ReadyStack build kit

The offline build kit for the Docker image `readystack/wordpress:7.1.5-CE-ubuntu24.04-r5`. It holds what the image is built from (upstream source, base images, toolchain, pinned dependencies) and the documents, so the image can be rebuilt with no network access (`docker build --network=none`).

- Release: [7.1.5-CE-ubuntu24.04-r5](https://github.com/readystack-dev/wordpress/releases/tag/7.1.5-CE-ubuntu24.04-r5)
- Image: [`docker.io/readystack/wordpress:7.1.5-CE-ubuntu24.04-r5`](https://hub.docker.com/r/readystack/wordpress/tags), manifest digest `sha256:42d0fb00e910d9fe4dc6bef5ad35c795d74e88eefb77b7c0a755eaaaba4a2a2f`
- Product page: https://readystack.dev/products/wordpress
- Defects: this repository's Issues (defects recorded from 25 November 2026 on) and https://readystack.dev/defects.html?product=wordpress

WordPress is distributed under its upstream licence (GPL-2.0-or-later); the kit contains upstream's source under that licence, and each vendored component under its own.

## Download

From the [7.1.5-CE-ubuntu24.04-r5 release](https://github.com/readystack-dev/wordpress/releases/tag/7.1.5-CE-ubuntu24.04-r5): `ReadyStack-wordpress-7.1.5-CE-ubuntu24.04-r5.tar.gz` (268.5 MB), SHA-256 `923db96ae632e8b84ce2db6c434096c5ac09a5a21e57241a6ba6f18c49f8b7a9`.

```sh
sha256sum --check --ignore-missing SHA256SUMS
```

## Verify and rebuild

The rebuild statement is signed with the ReadyStack release key. Check the signature before you rely on it:

```sh
cosign verify-blob --key https://readystack.dev/keys/cosign.pub \
  --bundle ReadyStack-wordpress-7.1.5-CE-ubuntu24.04-r5.rebuild.json.sigstore ReadyStack-wordpress-7.1.5-CE-ubuntu24.04-r5.rebuild.json
```

Unpack with `-p` so file modes are kept, then follow the kit's own README.md and docs/REBUILD.md:

```sh
tar -xpzf ReadyStack-wordpress-7.1.5-CE-ubuntu24.04-r5.tar.gz
cd 7.1.5-CE-ubuntu24.04-r5
less README.md docs/REBUILD.md
```

The build trail (`ReadyStack-wordpress-7.1.5-CE-ubuntu24.04-r5.trail.json`, signed the same way, and its Markdown copy) records how this release was built and checked.

## This repository

`recipe/` holds the kit's recipe files (Dockerfiles, build scripts, pins) as published at https://readystack.dev/products/wordpress/recipe. The complete kit is the release download. Each release is a tag here.
