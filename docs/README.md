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

Keep it short and let each step breathe for about a second. Signed in as
`admin@example.com`, with any photo ready on disk for step 2.

1. Land on the feed — scroll one or two threads into view
2. **Create** → fill a title and body, attach a picture → submit; the new thread
   opens with its image
3. Back to the feed — the new thread sits on top
4. Open *"Berapa lama waktu tidur ideal untuk orang dewasa?"* — it has comments
   and a nested reply
5. Upvote it — the count changes
6. Switch the language to Bahasa Indonesia from the navbar
7. Profile menu → **Doctor verifications** → **Approve** a pending doctor; the
   row moves down to *Approved*

## Recording

- **Windows:** ScreenToGif (free) records straight to `.gif` and lets you trim
  frames and cap the width.
- **Cross-platform:** record `.mp4` with OBS, then convert:

  ```bash
  ffmpeg -i demo.mp4 -vf "fps=12,scale=1200:-1:flags=lanczos" -loop 0 demo.gif
  ```

Keep the GIF under ~8 MB — GitHub serves larger files slowly and some readers
will never see it finish loading.
