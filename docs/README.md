# Media for the project README

`demo.gif` is the walkthrough shown at the top of the project README.

## Re-recording it

Run the app locally (`php artisan serve`) against a database seeded with
`--seed`, and sign in as `admin@example.com` / `password`. Put the text you plan
to type on the clipboard first — typing on camera eats a lot of seconds.

Record the browser in fullscreen (F11) so no tabs or taskbar end up in frame.
On Windows, `Win + Alt + R` starts and stops a Game Bar capture without opening
the overlay. Note that Game Bar records a single window, so it stops if a file
picker opens — upload any images before you start rolling.

A run worth capturing, roughly 30–40 seconds:

1. The feed, with a thread that has an image
2. Open a seeded thread — it has comments and a nested reply
3. Upvote it; the count changes
4. **Create** a thread, paste the title, submit
5. Switch the language from the navbar
6. Profile menu → **Doctor verifications** → **Approve** a pending doctor

## Turning the recording into the GIF

Trim to the parts worth keeping, then convert. Adjust the `trim` ranges to match
your own take:

```bash
ffmpeg -i capture.mp4 -filter_complex "\
[0:v]trim=0:6,setpts=PTS-STARTPTS[a];\
[0:v]trim=23:31.5,setpts=PTS-STARTPTS[b];\
[a][b]concat=n=2:v=1:a=0,fps=30,scale=1280:-2:flags=lanczos[v]" \
  -map "[v]" -an -c:v libx264 -preset slow -crf 24 -pix_fmt yuv420p cut.mp4

ffmpeg -i cut.mp4 -vf "fps=12,scale=960:-1:flags=lanczos,palettegen=max_colors=128:stats_mode=diff" palette.png
ffmpeg -i cut.mp4 -i palette.png -lavfi \
  "fps=12,scale=960:-1:flags=lanczos[x];[x][1:v]paletteuse=dither=bayer:bayer_scale=3:diff_mode=rectangle" \
  -loop 0 demo.gif
```

Screen recordings are mostly static frames, so this lands around 1 MB for half a
minute. Keep it under a few megabytes — GitHub serves larger files slowly.
