<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ConsultantSeeder extends Seeder
{
    public function run(): void
    {
        $consultants = [
            [
                'name'                => 'Patrick Mugisha',
                'title'               => 'Licensed Land Surveyor',
                'email'               => 'patrickmugisha@terra.rw',
                'phone'               => '+250788345678',
                'photo'               => 'consultants/patrick-mugisha.jpg',
                'bio'                 => 'Certified cadastral surveyor with 12 years of experience working with RLMUA. Expert in UPI registration, boundary demarcation, and land subdivision across all 30 districts of Rwanda.',
                'registration_number' => 'RLMUA-SUR-2014-0042',
                'cv'                  => 'consultants/cvs/patrick-mugisha-cv.pdf',
                'province'            => 'Kigali City',
                'district'            => 'Gasabo',
                'availability'        => 'Mon–Sat',
                'is_verified'         => 1,
                'views_count'         => 234,
                'unique_views_count'  => 198,
            ],
            [
                'name'                => 'Me. Aimable Hakizimana',
                'title'               => 'Real Estate Attorney',
                'email'               => 'aimable.h@terra.rw',
                'phone'               => '+250788456001',
                'photo'               => 'consultants/aimable-hakizimana.jpg',
                'bio'                 => 'Practicing attorney specializing in Rwandan property law, title deed transfers, and land dispute resolution. Admitted to the Rwanda Bar Association since 2010.',
                'registration_number' => 'RBA-2010-0187',
                'cv'                  => 'consultants/cvs/aimable-hakizimana-cv.pdf',
                'province'            => 'Kigali City',
                'district'            => 'Nyarugenge',
                'availability'        => 'Mon–Fri',
                'is_verified'         => 1,
                'views_count'         => 156,
                'unique_views_count'  => 132,
            ],
            [
                'name'                => 'Arch. Grace Iribagiza',
                'title'               => 'Registered Architect',
                'email'               => 'grace.i@terra.rw',
                'phone'               => '+250788567002',
                'photo'               => 'consultants/grace-iribagiza.jpg',
                'bio'                 => 'Rwanda Institute of Architects registered professional with expertise in sustainable residential design compliant with Kigali City master plan and Rwanda Building Code.',
                'registration_number' => 'RIA-2016-0098',
                'cv'                  => 'consultants/cvs/grace-iribagiza-cv.pdf',
                'province'            => 'Kigali City',
                'district'            => 'Kicukiro',
                'availability'        => 'Mon–Fri',
                'is_verified'         => 1,
                'views_count'         => 89,
                'unique_views_count'  => 76,
            ],
            [
                'name'                => 'Eng. Théogène Nsengiyumva',
                'title'               => 'Civil & Structural Engineer',
                'email'               => 'theogene.n@terra.rw',
                'phone'               => '+250788678003',
                'photo'               => 'consultants/theogene-nsengiyumva.jpg',
                'bio'                 => 'Licensed civil engineer with expertise in structural assessment, construction supervision, and building inspection. 10+ years of experience with Rwanda Housing Authority standards.',
                'registration_number' => 'RHA-ENG-2013-0156',
                'cv'                  => 'consultants/cvs/theogene-nsengiyumva-cv.pdf',
                'province'            => 'Southern Province',
                'district'            => 'Huye',
                'availability'        => 'Mon–Fri',
                'is_verified'         => 1,
                'views_count'         => 67,
                'unique_views_count'  => 55,
            ],
            [
                'name'                => 'Valérie Umutoni',
                'title'               => 'Property Valuation Expert',
                'email'               => 'valerie.u@terra.rw',
                'phone'               => '+250788789004',
                'photo'               => 'consultants/valerie-umutoni.jpg',
                'bio'                 => 'Certified property valuer with the Institute of Real Estate Valuers of Rwanda. Provides accurate market valuations for mortgage applications, tax assessments, and property transactions.',
                'registration_number' => 'IREV-2018-0073',
                'cv'                  => 'consultants/cvs/valerie-umutoni-cv.pdf',
                'province'            => 'Eastern Province',
                'district'            => 'Rwamagana',
                'availability'        => 'Mon–Sat',
                'is_verified'         => 0,
                'views_count'         => 45,
                'unique_views_count'  => 38,
            ],
        ];

        foreach ($consultants as $c) {
            // ── Auto-create user ──
            $userId = DB::table('users')->insertGetId([
                'name'       => $c['name'],
                'email'      => $c['email'],
                'password'   => Hash::make('password'),
                'role'       => 'consultant',
                'phone'      => $c['phone'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // ── Create consultant linked to that user ──
            DB::table('consultants')->insert([
                'user_id'             => $userId,
                'name'                => $c['name'],
                'title'               => $c['title'],
                'email'               => $c['email'],
                'phone'               => $c['phone'],
                'photo'               => $c['photo'],
                'bio'                 => $c['bio'],
                'registration_number' => $c['registration_number'],
                'cv'                  => $c['cv'],
                'is_active'           => 1,
                'province'            => $c['province'],
                'district'            => $c['district'],
                'availability'        => $c['availability'],
                'is_verified'         => $c['is_verified'],
                'views_count'         => $c['views_count'],
                'unique_views_count'  => $c['unique_views_count'],
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
        }
    }
}
