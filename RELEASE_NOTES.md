# WordPress 7.1.5 — ReadyStack release `7.1.5-CE-ubuntu24.04-r5`

Generated 2026-11-25 from this release's build records and strategy. Statements that come from a single record name it in brackets; the others come from this release's strategy and build log.

## Release

- **Image:** `readystack/wordpress:7.1.5-CE-ubuntu24.04-r5` (linux/amd64). Index digest `sha256:280423ff2fc300aa2613d51c72866dbda2766c3b44e821535849989b5c23c056` [`docs/provenance/LOCKED_DIGEST.txt`].
- **Image manifest digest:** `sha256:42d0fb00e910d9fe4dc6bef5ad35c795d74e88eefb77b7c0a755eaaaba4a2a2f` [`TARGET_DIGEST.txt`].
- **Upstream:** WordPress 7.1.5 built from source at `7.1.5` of https://github.com/WordPress/WordPress — upstream notes: https://wordpress.org/documentation/wordpress-version/version-7-1-5/ [`docs/provenance/BUILD_RECIPE.json`].
- **Base image:** `ubuntu:24.04`; runtime user `www-data`.
- **Build:** `source-rebuild-php`, built offline with `--network=none`.
- **Supersedes:** ReadyStack release `7.1.5-CE-ubuntu24.04-r4`.

## What changed in this release

- Upstream version unchanged (7.1.5); ReadyStack rebuild.
- WordPress 7.1.5 is unchanged from the release this supersedes (7.1.5-CE-ubuntu24.04-r4); this release rebuilds it. Changes: libheif-plugin-aomdec moves from 1.17.6-1ubuntu4.9 to 1.17.6-1ubuntu4.10 (USN-8846-2); libheif1 moves from 1.17.6-1ubuntu4.9 to 1.17.6-1ubuntu4.10 (USN-8846-2). Settings, ports and data volumes are those of 7.1.5-CE-ubuntu24.04-r4: replace the container with this image on the same volumes.

## Security status at release (measured 2026-11-25)

- **Docker Scout:** 0 fixable critical/high vulnerabilities; runs as `www-data` (non-root); SBOM + provenance attestations present (SPDX SBOM + SLSA v1) [`docs/provenance/SCOUT_VERDICT.json`].
- **OSV cross-check:** no fixable critical/high vulnerability beyond Docker Scout's findings.
- **Signature:** cosign signature verified by ReadyStack's release gate before publishing; check it yourself with `cosign verify --key https://readystack.dev/keys/cosign.pub readystack/wordpress:7.1.5-CE-ubuntu24.04-r5` (signatures are recorded in the public Sigstore transparency log).
- **ReadyStack release check at release:** passed (ReadyStack's own test, not a Docker Scout grade). Vulnerabilities are disclosed every day and the image never changes, so it is re-checked daily, beside Docker Scout's own dated grade, at https://readystack.dev/queue.
- **Before exposing this service:** When WORDPRESS_ADMIN_PASSWORD is not set, the first administrator's password is in /var/lib/wordpress/initial_admin_password on the wordpress-data volume. Read it, change the password in wp-admin, then delete the file.

## Reproducibility

Rebuilds offline from this archive to the identical image digest `sha256:42d0fb00e910d9fe4dc6bef5ad35c795d74e88eefb77b7c0a755eaaaba4a2a2f`: run `./BUILD_OFFLINE.sh`, then `./VERIFY_OFFLINE.sh` (add `--online` to confirm the Docker Hub tag holds the same digest). Before publishing, ReadyStack rebuilt the kit with `./BUILD_OFFLINE.sh` and compared the result with the published digest [`docs/provenance/REPRO_VERIFICATION.json`], then ran `./BUILD_OFFLINE.sh` and `./VERIFY_OFFLINE.sh` from this archive (without `--online`).

## Validation

- 4 of 4 use cases passed (4 authored) against the running image [`docs/validation/test-results.json`].

## Known issues

- **medium** (ReadyStack package): The seed-data record says the product has no SQL database ('config/CRD-native product') [`RSD-wordpress-f6d97587dc`] (carried from `7.1.2-CE-debian-bookworm-r1`, recorded there as `RSD-wordpress-2bff3d66ba`)

## Defects fixed

- 1 problem found before release and fixed before it shipped (1 by review); each is listed in `docs/defects/defects.json`.

## Verify this archive

```
sha256sum -c CHECKSUMS.sha256
./BUILD_OFFLINE.sh && ./VERIFY_OFFLINE.sh --online
cosign verify --key https://readystack.dev/keys/cosign.pub readystack/wordpress:7.1.5-CE-ubuntu24.04-r5
```

ReadyStack records every signature in the public Sigstore transparency log (Rekor), so the command needs no extra flags.

