# Media for the project README

The top-level `README.md` expects four files in this folder. Capture them from a
locally running instance (`php artisan serve`) seeded with `--seed`, signed in as
`admin@example.com` / `password`.

| File | What to capture | Size |
| --- | --- | --- |
| `demo.gif` | 15–20s walkthrough, see the script below | ≤ 1200px wide, under ~8 MB |
| `thread-detail.png` | A thread with comments and a nested reply | ~1280px wide |
| `admin.png` | `/admin/doctor-verifications` with pending + approved rows | ~1280px wide |
| `mobile.png` | The feed at a 375px viewport, navbar menu open | ~375px wide |

## demo.gif script

Keep it short and let each step breathe for about a second.

1. Land on the feed — scroll one or two threads into view
2. Open a thread — show the comments and a nested reply
3. Vote on the thread (the count changes)
4. Switch the language to Bahasa Indonesia via the navbar
5. Open the profile menu → **Doctor verifications**
6. Approve one pending doctor — the row moves to *Approved*

## Recording

- **Windows:** ScreenToGif (free) records straight to `.gif` and lets you trim
  frames and cap the width.
- **Cross-platform:** record `.mp4` with OBS, then convert:

  ```bash
  ffmpeg -i demo.mp4 -vf "fps=12,scale=1200:-1:flags=lanczos" -loop 0 demo.gif
  ```

Keep the GIF under ~8 MB — GitHub serves larger files slowly and some readers
will never see it finish loading.
