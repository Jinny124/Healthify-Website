# Media for the project README

Capture these from a locally running instance (`php artisan serve`) seeded with
`--seed`, signed in as `admin@example.com` / `password`.

| What | Where it lives | Size |
| --- | --- | --- |
| Walkthrough video | Uploaded to GitHub, linked from `README.md` — see below | 15–25s |
| `thread-detail.png` | This folder | ~1280px wide |
| `admin.png` | This folder | ~1280px wide |
| `mobile.png` | This folder | ~375px wide |

`thread-detail.png` shows a thread with comments and a nested reply, `admin.png`
shows `/admin/doctor-verifications` with pending and approved rows, and
`mobile.png` shows the feed at a 375px viewport with the navbar menu open.

## Hosting the video

GitHub plays videos inline in a README, which looks better than a GIF and keeps
the file out of the repository:

1. Record the walkthrough to `.mp4` (Win + G on Windows).
2. Open a **new issue** on the repository — do not submit it.
3. Drag the `.mp4` into the comment box and wait for the upload to finish.
4. Copy the `https://github.com/user-attachments/assets/…` URL it inserts.
5. Put that URL on its own line in `README.md`; discard the draft issue.

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
