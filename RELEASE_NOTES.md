# WordPress 7.1.5 — ReadyStack release `7.1.5-CE-ubuntu24.04-r6`

Generated 2026-11-25 from this release's build records and strategy. Statements that come from a single record name it in brackets; the others come from this release's strategy and build log.

## Release

- **Image:** `readystack/wordpress:7.1.5-CE-ubuntu24.04-r6` (linux/amd64). Index digest `sha256:36f2a773b339455faf5c492fd573c80f06979fa16aa22a81d159e102f1a3b396` [`docs/provenance/LOCKED_DIGEST.txt`].
- **Image manifest digest:** `sha256:e94ad90b14151644950c33db33fe845b979212fd21fe628c12c36a9ddb3f6975` [`TARGET_DIGEST.txt`].
- **Upstream:** WordPress 7.1.5 built from source at `7.1.5` of https://github.com/WordPress/WordPress — upstream notes: https://wordpress.org/documentation/wordpress-version/version-7-1-5/ [`docs/provenance/BUILD_RECIPE.json`].
- **Base image:** `ubuntu:24.04`; runtime user `www-data`.
- **Build:** `source-rebuild-php`, built offline with `--network=none`.
- **Supersedes:** ReadyStack release `7.1.5-CE-ubuntu24.04-r5`.

## What changed in this release

- Upstream version unchanged (7.1.5); ReadyStack rebuild.
- WordPress 7.1.5 is unchanged from the release this supersedes (7.1.5-CE-ubuntu24.04-r5); this release rebuilds it. Changes: libexpat1 moves from 2.6.1-2ubuntu0.6 to 2.6.1-2ubuntu0.7 (USN-9196-1). Settings, ports and data volumes are those of 7.1.5-CE-ubuntu24.04-r5: replace the container with this image on the same volumes.

## Security status at release (measured 2026-11-25)

- **Docker Scout:** 0 fixable critical/high vulnerabilities; runs as `www-data` (non-root); SBOM + provenance attestations present (SPDX SBOM + SLSA v1) [`docs/provenance/SCOUT_VERDICT.json`].
- **OSV cross-check:** no fixable critical/high vulnerability beyond Docker Scout's findings.
- **Signature:** cosign signature verified by ReadyStack's release gate before publishing; check it yourself with `cosign verify --key https://readystack.dev/keys/cosign.pub readystack/wordpress:7.1.5-CE-ubuntu24.04-r6` (signatures are recorded in the public Sigstore transparency log).
- **ReadyStack release check at release:** passed (ReadyStack's own test, not a Docker Scout grade). Vulnerabilities are disclosed every day and the image never changes, so it is re-checked daily, beside Docker Scout's own dated grade, at https://readystack.dev/queue.
- **Before exposing this service:** When WORDPRESS_ADMIN_PASSWORD is not set, the first administrator's password is in /var/lib/wordpress/initial_admin_password on the wordpress-data volume. Read it, change the password in wp-admin, then delete the file.

## Reproducibility

Rebuilds offline from this archive to the identical image digest `sha256:e94ad90b14151644950c33db33fe845b979212fd21fe628c12c36a9ddb3f6975`: run `./BUILD_OFFLINE.sh`, then `./VERIFY_OFFLINE.sh` (add `--online` to confirm the Docker Hub tag holds the same digest). Before publishing, ReadyStack rebuilt the kit with `./BUILD_OFFLINE.sh` and compared the result with the published digest [`docs/provenance/REPRO_VERIFICATION.json`], then ran `./BUILD_OFFLINE.sh` and `./VERIFY_OFFLINE.sh` from this archive (without `--online`).

## Validation

- 4 of 4 use cases passed (5 authored, 4 kept in the suite; 1 not exercised, see below) against the running image [`docs/validation/test-results.json`].
- 1 further authored check was not exercised and is not counted above: it expected HTTP 200 from `/wp-admin/install.php`, which this image refuses to everyone with HTTP 403 by design (listed under Not exercised in `docs/validation/FAILED_TESTS.md`).

## Known issues

- **medium** (ReadyStack package): The seed-data record says the product has no SQL database ('config/CRD-native product') [`RSD-wordpress-ccb140e907`] (carried from `7.1.2-CE-debian-bookworm-r1`, recorded there as `RSD-wordpress-2bff3d66ba`)

## Defects fixed

- 1 problem found before release and fixed before it shipped (1 by review); each is listed in `docs/defects/defects.json`.

## Verify this archive

```
sha256sum -c CHECKSUMS.sha256
./BUILD_OFFLINE.sh && ./VERIFY_OFFLINE.sh --online
cosign verify --key https://readystack.dev/keys/cosign.pub readystack/wordpress:7.1.5-CE-ubuntu24.04-r6
```

ReadyStack records every signature in the public Sigstore transparency log (Rekor), so the command needs no extra flags.

