<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat User Admin
        User::create([
            'username' => 'admin',
            'name' => 'Admin N*JM Hotel',
            'email' => 'admin@hotel.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // 2. Buat Data Kamar
        $rooms = [
            [
                'nomor_kamar' => '101',
                'tipe_kamar' => 'Standard Room',
                'harga_per_malam' => 350000,
                'kapasitas' => 2,
                'deskripsi' => 'Kamar Standard yang nyaman dengan 1 double bed atau 2 single bed, pendingin ruangan (AC), TV LED, akses Wi-Fi gratis, dan kamar mandi dalam dilengkapi dengan shower.',
                'foto_kamar' => 'gambar/kamar/standard/standard1.jpg',
                'status' => 'tersedia',
            ],
            [
                'nomor_kamar' => '102',
                'tipe_kamar' => 'Standard Room',
                'harga_per_malam' => 350000,
                'kapasitas' => 2,
                'deskripsi' => 'Kamar Standard dengan desain minimalis modern. Dilengkapi dengan 1 double bed, AC, lemari pakaian, TV flat-screen, Wi-Fi gratis, serta kamar mandi shower air hangat.',
                'foto_kamar' => 'gambar/kamar/standard/standard2.jpg',
                'status' => 'tersedia',
            ],
            [
                'nomor_kamar' => '103',
                'tipe_kamar' => 'Standard Room',
                'harga_per_malam' => 350000,
                'kapasitas' => 2,
                'deskripsi' => 'Kamar Standard dengan fasilitas AC, Wi-Fi gratis, TV, dan 2 single bed. Cocok untuk menginap bersama teman atau kolega.',
                'foto_kamar' => 'gambar/kamar/standard/standard3.jpg',
                'status' => 'perbaikan',
            ],
            [
                'nomor_kamar' => '201',
                'tipe_kamar' => 'Deluxe Room',
                'harga_per_malam' => 600000,
                'kapasitas' => 2,
                'deskripsi' => 'Kamar Deluxe yang luas dengan pemandangan kota. Dilengkapi king-size bed, AC, kulkas mini, teko listrik (kopi/teh gratis), TV kabel, Wi-Fi cepat, dan kamar mandi dengan bathub.',
                'foto_kamar' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=600&q=80',
                'status' => 'tersedia',
            ],
            [
                'nomor_kamar' => '202',
                'tipe_kamar' => 'Deluxe Room',
                'harga_per_malam' => 600000,
                'kapasitas' => 2,
                'deskripsi' => 'Kamar Deluxe dengan dekorasi elegan. Fasilitas premium meliputi king bed, meja kerja, minibar, AC, safety box, TV pintar 43 inci, shower air panas, serta amenities lengkap.',
                'foto_kamar' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=600&q=80',
                'status' => 'tersedia',
            ],
            [
                'nomor_kamar' => '301',
                'tipe_kamar' => 'VIP Room',
                'harga_per_malam' => 1200000,
                'kapasitas' => 4,
                'deskripsi' => 'Kamar VIP mewah yang memiliki ruang tamu terpisah (living room). Sangat cocok untuk keluarga. Fasilitas termasuk super king bed, AC di setiap ruangan, TV pintar 50 inci, minibar lengkap, microwave, mesin kopi, sofa bed, dan kamar mandi mewah dengan bathub dan shower terpisah.',
                'foto_kamar' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=600&q=80',
                'status' => 'tersedia',
            ],
            [
                'nomor_kamar' => '302',
                'tipe_kamar' => 'VIP Room',
                'harga_per_malam' => 1200000,
                'kapasitas' => 4,
                'deskripsi' => 'VIP Room bertipe presidential suite junior dengan pemandangan pegunungan yang menawan. Lengkap dengan area santai keluarga, balkon pribadi, fasilitas pembuat kopi espresso, kulkas besar, shower modern, bathub mewah, dan perlengkapan mandi eksklusif.',
                'foto_kamar' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=600&q=80',
                'status' => 'tersedia',
            ],
        ];

        $createdRooms = [];
        foreach ($rooms as $room) {
            $createdRooms[] = Room::create($room);
        }

        // 3. Buat Contoh Reservasi
        $reservations = [
            [
                'kode_booking' => 'REV-20260610-001',
                'nama_tamu' => 'Budi Santoso',
                'email_tamu' => 'budi@gmail.com',
                'telepon_tamu' => '081234567890',
                'room_id' => $createdRooms[0]->id, // Kamar 101 (Standard)
                'tanggal_check_in' => '2026-06-10',
                'tanggal_check_out' => '2026-06-12',
                'total_harga' => 700000, // 350.000 * 2 malam
                'status' => 'check_out',
                'catatan' => 'Minta double bed dan lantai bawah.',
            ],
            [
                'kode_booking' => 'REV-20260615-001',
                'nama_tamu' => 'Siti Rahma',
                'email_tamu' => 'siti@yahoo.com',
                'telepon_tamu' => '082143658709',
                'room_id' => $createdRooms[3]->id, // Kamar 201 (Deluxe)
                'tanggal_check_in' => '2026-06-15',
                'tanggal_check_out' => '2026-06-18',
                'total_harga' => 1800000, // 600.000 * 3 malam
                'status' => 'check_out',
                'catatan' => 'Non-smoking room please.',
            ],
            [
                'kode_booking' => 'REV-20260622-001',
                'nama_tamu' => 'Joko Widodo',
                'email_tamu' => 'jokowi@gmail.com',
                'telepon_tamu' => '083152769843',
                'room_id' => $createdRooms[5]->id, // Kamar 301 (Suite)
                'tanggal_check_in' => '2026-06-22',
                'tanggal_check_out' => '2026-06-24',
                'total_harga' => 2400000, // 1.200.000 * 2 malam
                'status' => 'check_in',
                'catatan' => 'Minta buah segar sebagai complimentary di kamar.',
            ],
            [
                'kode_booking' => 'REV-20260625-001',
                'nama_tamu' => 'Ani Wijaya',
                'email_tamu' => 'ani.wijaya@outlook.com',
                'telepon_tamu' => '084592817364',
                'room_id' => $createdRooms[1]->id, // Kamar 102 (Standard)
                'tanggal_check_in' => '2026-06-25',
                'tanggal_check_out' => '2026-06-27',
                'total_harga' => 700000, // 350.000 * 2 malam
                'status' => 'dikonfirmasi',
                'catatan' => 'Late check-in sekitar jam 7 malam.',
            ],
        ];

        foreach ($reservations as $reservation) {
            Reservation::create($reservation);
        }
    }
}

