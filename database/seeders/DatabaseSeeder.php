<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Thread;
use App\Models\Upvote;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with a realistic demo data set.
     *
     * All accounts use the password: "password".
     */
    public function run(): void
    {
        // --- Known demo accounts -------------------------------------------------
        $alice = User::factory()->create([
            'name' => 'Alice Putri',
            'email' => 'alice@example.com',
        ]);

        $citra = User::factory()->create([
            'name' => 'Citra Dewi',
            'email' => 'citra@example.com',
        ]);

        $drBudi = User::factory()->doctor()->create([
            'name' => 'dr. Budi Santoso',
            'email' => 'budi@example.com',
        ]);

        User::factory()->admin()->create([
            'name' => 'Site Admin',
            'email' => 'admin@example.com',
        ]);

        // A doctor application still waiting for admin review.
        User::factory()->pendingDoctor()->create([
            'name' => 'dr. Dewi Lestari',
            'email' => 'dewi@example.com',
        ]);

        // --- Extra random users ------------------------------------------------
        $members = User::factory(8)->create();
        $doctors = User::factory(3)->doctor()->create();
        User::factory(2)->pendingDoctor()->create();

        $everyone = collect([$alice, $citra, $drBudi])
            ->concat($members)
            ->concat($doctors);

        // --- Threads (health forum themed) -----------------------------------
        $topics = [
            [
                'Tips menjaga tekanan darah tetap stabil',
                'Belakangan ini tensi saya naik turun. Selain kurangi garam, apa lagi yang bisa dilakukan sehari-hari? Sharing pengalaman dong.',
            ],
            [
                'Berapa lama waktu tidur ideal untuk orang dewasa?',
                'Saya biasa tidur jam 1 pagi dan bangun jam 6. Apakah 5 jam cukup kalau kualitasnya bagus, atau tetap kurang?',
            ],
            [
                'Olahraga ringan yang aman untuk pemula',
                'Sudah lama tidak olahraga dan berat badan naik. Mau mulai pelan-pelan. Rekomendasi rutinitas 15-20 menit per hari?',
            ],
            [
                'Cara mengurangi konsumsi gula tanpa tersiksa',
                'Setiap sore selalu ingin yang manis. Ada trik mengganti kebiasaan ngemil manis dengan sesuatu yang lebih sehat?',
            ],
            [
                'Apakah suplemen vitamin D benar-benar perlu?',
                'Jarang kena matahari karena kerja di dalam ruangan seharian. Perlukah suplemen, atau cukup dari makanan?',
            ],
            [
                'Mengelola stres kerja yang berkepanjangan',
                'Deadline menumpuk dan susah tidur karena kepikiran kerjaan. Teknik apa yang benar-benar membantu buat kalian?',
            ],
            [
                'Nyeri punggung bawah setelah duduk lama',
                'Kerja remote, duduk 8 jam sehari. Punggung bawah pegal terus. Peregangan atau perubahan posisi seperti apa yang membantu?',
            ],
            [
                'Menjaga daya tahan tubuh saat pergantian musim',
                'Tiap musim hujan pasti kena batuk pilek. Kebiasaan apa yang bisa mengurangi risiko gampang sakit?',
            ],
            [
                'Porsi makan sehat tanpa harus menghitung kalori',
                'Menghitung kalori bikin capek. Ada pendekatan yang lebih simpel untuk kontrol porsi harian?',
            ],
            [
                'Kapan sakit kepala perlu diperiksakan ke dokter?',
                'Sakit kepala tegang beberapa kali seminggu. Kapan ini termasuk wajar dan kapan harus diperiksa lebih lanjut?',
            ],
        ];

        $replies = [
            'Terima kasih sharing-nya, sangat membantu.',
            'Saya juga mengalami hal serupa, akhirnya rutin jalan kaki pagi 20 menit dan terasa bedanya.',
            'Coba konsultasikan ke dokter dulu ya biar aman, terutama kalau ada riwayat penyakit.',
            'Kuncinya konsisten, bukan intensitas. Mulai dari yang kecil dulu.',
            'Minum air putih yang cukup sering diremehkan padahal pengaruhnya besar.',
            'Sudah coba beberapa minggu dan hasilnya lumayan, semangat!',
            'Menurut yang saya baca, kualitas tidur sama pentingnya dengan durasi.',
            'Kalau gejalanya menetap lebih dari dua minggu sebaiknya periksa langsung.',
            'Boleh dijelaskan lebih detail rutinitas hariannya seperti apa?',
            'Setuju, perubahan gaya hidup memang butuh waktu untuk terlihat hasilnya.',
        ];

        $doctorNotes = [
            'Sebagai catatan medis umum: perubahan pola makan dan aktivitas fisik biasanya dianjurkan lebih dulu sebelum mempertimbangkan obat, kecuali ada indikasi khusus.',
            'Jika keluhan disertai gejala lain seperti sesak, nyeri dada, atau demam tinggi, sebaiknya segera periksa ke fasilitas kesehatan terdekat.',
            'Informasi di forum ini bersifat edukatif dan tidak menggantikan pemeriksaan langsung oleh tenaga medis.',
        ];

        $createdThreads = collect($topics)->map(function (array $topic) use ($everyone) {
            return Thread::create([
                'user_id' => $everyone->random()->id,
                'title' => $topic[0],
                'body' => $topic[1],
            ]);
        });

        // --- Comments, doctor answers, and nested replies -------------------
        foreach ($createdThreads as $thread) {
            $commentCount = random_int(2, 5);

            for ($i = 0; $i < $commentCount; $i++) {
                $author = $everyone->random();

                $body = $author->role === 'doctor' && random_int(0, 1) === 1
                    ? $doctorNotes[array_rand($doctorNotes)]
                    : $replies[array_rand($replies)];

                $comment = Comment::create([
                    'thread_id' => $thread->id,
                    'user_id' => $author->id,
                    'parent_comment_id' => null,
                    'body' => $body,
                ]);

                // Occasionally add a reply to this comment.
                if (random_int(0, 2) === 0) {
                    Comment::create([
                        'thread_id' => $thread->id,
                        'user_id' => $everyone->random()->id,
                        'parent_comment_id' => $comment->id,
                        'body' => $replies[array_rand($replies)],
                    ]);
                }
            }
        }

        // --- Votes on threads ---------------------------------------------------
        foreach ($createdThreads as $thread) {
            $voters = $everyone->shuffle()->take(random_int(3, $everyone->count()));

            foreach ($voters as $voter) {
                Upvote::firstOrCreate(
                    [
                        'user_id' => $voter->id,
                        'votable_id' => $thread->id,
                        'votable_type' => Thread::class,
                    ],
                    ['vote_type' => random_int(0, 3) === 0 ? 'downvote' : 'upvote'],
                );
            }
        }

        // --- Votes on a sample of comments -----------------------------------
        $comments = Comment::all();

        foreach ($comments->random(min(20, $comments->count())) as $comment) {
            $voters = $everyone->shuffle()->take(random_int(1, 5));

            foreach ($voters as $voter) {
                Upvote::firstOrCreate(
                    [
                        'user_id' => $voter->id,
                        'votable_id' => $comment->id,
                        'votable_type' => Comment::class,
                    ],
                    ['vote_type' => random_int(0, 2) === 0 ? 'downvote' : 'upvote'],
                );
            }
        }
    }
}
