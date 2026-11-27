[![ReadyStack](https://readystack.dev/logo.svg)](https://readystack.dev)

**Stable, Open-source Releases, Automated** · [readystack.dev](https://readystack.dev)

[![Docker Hub](https://img.shields.io/badge/Docker%20Hub-readystack%2Fwordpress-2496ED?logo=docker&logoColor=white)](https://hub.docker.com/r/readystack/wordpress) [![Docker pulls](https://img.shields.io/docker/pulls/readystack/wordpress)](https://hub.docker.com/r/readystack/wordpress) [![Grade at release](https://img.shields.io/badge/grade%20at%20release-A%20%2894%25%29-2ea44f)](https://readystack.dev/products/wordpress) [![Signed: cosign](https://img.shields.io/badge/signed-cosign-2ea44f)](https://readystack.dev/keys/cosign.pub) ![SBOM: SPDX](https://img.shields.io/badge/SBOM-SPDX-2ea44f) ![Provenance: SLSA v1](https://img.shields.io/badge/provenance-SLSA%20v1-2ea44f) ![Offline rebuild: verified](https://img.shields.io/badge/offline%20rebuild-verified-2ea44f)

# WordPress: ReadyStack build kit

The offline build kit for the Docker image `readystack/wordpress:7.1.5-CE-ubuntu24.04-r7`. It holds what the image is built from (upstream source, base images, toolchain, pinned dependencies) and the documents, so the image can be rebuilt with no network access (`docker build --network=none`).

- Release: [7.1.5-CE-ubuntu24.04-r7](https://github.com/readystack-dev/wordpress/releases/tag/7.1.5-CE-ubuntu24.04-r7)
- Image: [`docker.io/readystack/wordpress:7.1.5-CE-ubuntu24.04-r7`](https://hub.docker.com/r/readystack/wordpress/tags), manifest digest `sha256:6f413a20130bd32fc68b53773a832ba9d1f0c787adeaa9eb9671c448fdaa7bb1`
- Product page: https://readystack.dev/products/wordpress
- Source and build recipe: https://readystack.dev/products/wordpress/recipe
- Build trail: https://readystack.dev/products/wordpress/trail/7.1.5-CE-ubuntu24.04-r7
- Defects: this repository's Issues (defects recorded from 25 November 2026 on) and https://readystack.dev/defects.html?product=wordpress

## The image

Single container: Apache with mod_php, one foreground process, running WordPress 7.1.5 as www-data (uid 33) on port 8080. Self-contained by default: the database is an embedded SQLite file on the wordpress-data volume, through WordPress.org's SQLite Database Integration drop-in, so no database server and no second container are needed. Set WORDPRESS_DB_HOST and WORDPRESS_DB_PASSWORD (WORDPRESS_DB_NAME and WORDPRESS_DB_USER default to wordpress) to use your own MySQL or MariaDB server instead, the databases WordPress itself is built for. WordPress is installed by the container at its first start; the web installer is never served.

## Who uses WordPress and why

Bloggers, small businesses, publishers and organisations who build and run websites.

WordPress is open-source publishing software for websites and blogs. Write and schedule posts and pages, manage media and users with roles, and extend the site with themes and plugins.

A typical use: A local business wants a website its staff can update without a developer. With WordPress they pick a theme, the owner writes and schedules news posts, an editor manages the pages and images, and plugins add a calendar and spam protection for comments.

From the upstream project's own description: https://wordpress.org/about/, https://wordpress.org/about/features/, https://github.com/WordPress/WordPress.

## This release

- Docker Scout policy grade at release: **A** (94%), graded 2026-11-27 with `docker scout policy` (CLI 1.26.0, docker-default configuration).
  - Docker Scout counts 135 packages with copyleft licences (GPL, LGPL, MPL), all of them operating-system packages (it counts only packages whose licence it can read; the SBOM lists every component).
- Signed with ReadyStack's release key (fingerprint `04daa92344a52dbc`): https://readystack.dev/keys/cosign.pub.
- Runs as a non-root user (`www-data`).
- Attestations on the image: an SPDX SBOM and SLSA provenance v1.
- Rebuilt from this kit with network egress blocked on 2026-11-27; the rebuilt image digest is the published one.
- Base: Ubuntu 24.04.

The current grade, measured again every day, is on https://readystack.dev/products/wordpress.

WordPress is distributed under its upstream licence (GPL-2.0-or-later); the kit contains upstream's source under that licence, and each vendored component under its own.

## Download

From the [7.1.5-CE-ubuntu24.04-r7 release](https://github.com/readystack-dev/wordpress/releases/tag/7.1.5-CE-ubuntu24.04-r7): `ReadyStack-wordpress-7.1.5-CE-ubuntu24.04-r7.tar.gz` (268.5 MB), SHA-256 `ff63bf2673f053e5b5172b4fefb43820a741712dac2573f67aa28e0f4972e62d`.

```sh
sha256sum --check --ignore-missing SHA256SUMS
```

## Verify and rebuild

The rebuild statement is signed with the ReadyStack release key. Check the signature before you rely on it:

```sh
cosign verify-blob --key https://readystack.dev/keys/cosign.pub \
  --bundle ReadyStack-wordpress-7.1.5-CE-ubuntu24.04-r7.rebuild.json.sigstore ReadyStack-wordpress-7.1.5-CE-ubuntu24.04-r7.rebuild.json
```

Unpack with `-p` so file modes are kept, then follow the kit's own README.md and docs/REBUILD.md:

```sh
tar -xpzf ReadyStack-wordpress-7.1.5-CE-ubuntu24.04-r7.tar.gz
cd 7.1.5-CE-ubuntu24.04-r7
less README.md docs/REBUILD.md
```

The build trail (`ReadyStack-wordpress-7.1.5-CE-ubuntu24.04-r7.trail.json`, signed the same way, and its Markdown copy) records how this release was built and checked.

## This repository

`recipe/` holds the kit's recipe files (Dockerfiles, build scripts, pins) as published at https://readystack.dev/products/wordpress/recipe. The complete kit is the release download. Each release is a tag here. How to report a vulnerability: [SECURITY.md](SECURITY.md).

## About ReadyStack

**Stable, Open-source Releases, Automated.** ReadyStack releases popular open-source apps every week with every available critical and high security fix applied, plus full documentation, reference data, tests and a build recipe that recreates each release bit-for-bit. Each release is rebuilt from its pinned inputs with the network off, checked against its published digest, signed, and scanned and graded again every day. The images and build kits are free, and ReadyStack is soon to be a nonprofit.

[readystack.dev](https://readystack.dev) · [All products](https://readystack.dev/products.html) · [Build kits on GitHub](https://github.com/readystack-dev) · [Defect log](https://readystack.dev/defects.html) · contact@readystack.dev

— ReadyStack · https://readystack.dev
