<?php

namespace Database\Seeders;

use App\Models\Raffle;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RaffleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a sample organizer user if it doesn't exist
        $organizer = User::firstOrCreate(
            ['email' => 'organizer@rifassys.com'],
            [
                'name' => 'Organizador Exemplo',
                'phone' => '(11) 99999-9999',
                'document' => '12345678901',
                'password' => Hash::make('password'),
            ]
        );

        // Create sample raffles
        $raffles = [
            [
                'title' => 'Rifa Solidária Animal',
                'description' => 'Ajude nosso abrigo de cães a continuar salvando vidas. Cada bilhete comprado contribui para alimentação, medicamentos e cuidados veterinários dos nossos amigos de quatro patas.',
                'prize_description' => 'iPhone 15 Pro Max 256GB - Cor Natural Titanium',
                'prize_image' => null,
                'price_per_ticket' => 5.00,
                'total_tickets' => 1000,
                'sold_tickets' => 850,
                'draw_date' => now()->addDays(15),
                'status' => 'active',
                'category' => 'social',
                'state' => 'São Paulo',
                'city' => 'São Paulo',
                'neighborhood' => 'Vila Madalena',
                'address' => 'Rua Harmonia, 123',
                'zip_code' => '05435-030',
                'organizer_id' => $organizer->id,
                'featured' => true,
                'min_tickets_to_draw' => 800,
                'terms_conditions' => 'Sorteio será realizado na data prevista. Participantes devem ter 18 anos ou mais.',
                'contact_info' => 'WhatsApp: (11) 99999-9999 | Email: contato@abrigoanimal.com',
                'goal_amount' => 5000.00,
                'current_amount' => 4250.00,
                'payment_methods' => ['pix', 'credit_card'],
                'social_media_links' => [
                    'instagram' => 'https://instagram.com/abrigoanimal',
                    'facebook' => 'https://facebook.com/abrigoanimal'
                ],
                'is_public' => true,
                'auto_draw' => true,
                'notify_winners' => true,
            ],
            [
                'title' => 'Tratamento Médico - João',
                'description' => 'João precisa de um tratamento médico urgente e custoso. Sua família está se mobilizando para arrecadar fundos através desta rifa solidária. Cada contribuição faz a diferença!',
                'prize_description' => 'Smartphone Samsung Galaxy S24 Ultra 512GB',
                'prize_image' => null,
                'price_per_ticket' => 10.00,
                'total_tickets' => 500,
                'sold_tickets' => 225,
                'draw_date' => now()->addDays(20),
                'status' => 'active',
                'category' => 'medical',
                'state' => 'Rio de Janeiro',
                'city' => 'Rio de Janeiro',
                'neighborhood' => 'Copacabana',
                'address' => 'Av. Atlântica, 456',
                'zip_code' => '22070-011',
                'organizer_id' => $organizer->id,
                'featured' => false,
                'min_tickets_to_draw' => 400,
                'terms_conditions' => 'Sorteio será realizado quando atingir o número mínimo de bilhetes vendidos.',
                'contact_info' => 'WhatsApp: (11) 88888-8888 | Email: familiajoao@gmail.com',
                'goal_amount' => 5000.00,
                'current_amount' => 2250.00,
                'payment_methods' => ['pix'],
                'social_media_links' => [
                    'instagram' => 'https://instagram.com/ajudejoao'
                ],
                'is_public' => true,
                'auto_draw' => true,
                'notify_winners' => true,
            ],
            [
                'title' => 'Bolsa de Estudos - Jovens Talentos',
                'description' => 'Apoie jovens talentosos que não têm condições financeiras para estudar. Esta rifa visa arrecadar fundos para bolsas de estudo em cursos técnicos e superiores.',
                'prize_description' => 'Notebook Dell Inspiron 15 3000 - Intel i5, 8GB RAM, 256GB SSD',
                'prize_image' => null,
                'price_per_ticket' => 15.00,
                'total_tickets' => 800,
                'sold_tickets' => 576,
                'draw_date' => now()->addDays(25),
                'status' => 'active',
                'category' => 'education',
                'state' => 'Minas Gerais',
                'city' => 'Belo Horizonte',
                'neighborhood' => 'Savassi',
                'address' => 'Rua Pernambuco, 789',
                'zip_code' => '30130-150',
                'organizer_id' => $organizer->id,
                'featured' => true,
                'min_tickets_to_draw' => 600,
                'terms_conditions' => 'Sorteio será realizado na data prevista. Todos os participantes receberão confirmação por email.',
                'contact_info' => 'WhatsApp: (11) 77777-7777 | Email: jovemstalentos@ong.org',
                'goal_amount' => 12000.00,
                'current_amount' => 8640.00,
                'payment_methods' => ['pix', 'credit_card', 'debit_card'],
                'social_media_links' => [
                    'instagram' => 'https://instagram.com/jovemstalentos',
                    'facebook' => 'https://facebook.com/jovemstalentos',
                    'tiktok' => 'https://tiktok.com/@jovemstalentos'
                ],
                'is_public' => true,
                'auto_draw' => true,
                'notify_winners' => true,
            ],
            [
                'title' => 'Reforma da Igreja São João',
                'description' => 'Nossa comunidade precisa reformar a Igreja São João. O telhado está com infiltrações e precisa de reparos urgentes. Ajude-nos a manter este espaço sagrado!',
                'prize_description' => 'Moto Honda CG 160 Titan S - 2024',
                'prize_image' => null,
                'price_per_ticket' => 20.00,
                'total_tickets' => 1000,
                'sold_tickets' => 320,
                'draw_date' => now()->addDays(30),
                'status' => 'active',
                'category' => 'religious',
                'state' => 'Bahia',
                'city' => 'Salvador',
                'neighborhood' => 'Pelourinho',
                'address' => 'Rua do Pelourinho, 321',
                'zip_code' => '40026-010',
                'organizer_id' => $organizer->id,
                'featured' => false,
                'min_tickets_to_draw' => 800,
                'terms_conditions' => 'Sorteio será realizado quando atingir o número mínimo de bilhetes vendidos.',
                'contact_info' => 'WhatsApp: (11) 66666-6666 | Email: igrejasaojoao@paroquia.com',
                'goal_amount' => 20000.00,
                'current_amount' => 6400.00,
                'payment_methods' => ['pix', 'credit_card'],
                'social_media_links' => [
                    'instagram' => 'https://instagram.com/igrejasaojoao'
                ],
                'is_public' => true,
                'auto_draw' => true,
                'notify_winners' => true,
            ],
            [
                'title' => 'Evento Beneficente - Creche Esperança',
                'description' => 'A Creche Esperança precisa de recursos para melhorar a infraestrutura e oferecer melhor atendimento às crianças carentes da nossa comunidade.',
                'prize_description' => 'TV Samsung 55" QLED 4K Smart TV',
                'prize_image' => null,
                'price_per_ticket' => 8.00,
                'total_tickets' => 1500,
                'sold_tickets' => 1125,
                'draw_date' => now()->addDays(18),
                'status' => 'active',
                'category' => 'social',
                'state' => 'Ceará',
                'city' => 'Fortaleza',
                'neighborhood' => 'Meireles',
                'address' => 'Av. Beira Mar, 654',
                'zip_code' => '60165-121',
                'organizer_id' => $organizer->id,
                'featured' => true,
                'min_tickets_to_draw' => 1000,
                'terms_conditions' => 'Sorteio será realizado na data prevista. Participantes devem ter 18 anos ou mais.',
                'contact_info' => 'WhatsApp: (11) 55555-5555 | Email: crecheesperanca@ong.org',
                'goal_amount' => 12000.00,
                'current_amount' => 9000.00,
                'payment_methods' => ['pix', 'credit_card', 'debit_card'],
                'social_media_links' => [
                    'instagram' => 'https://instagram.com/crecheesperanca',
                    'facebook' => 'https://facebook.com/crecheesperanca'
                ],
                'is_public' => true,
                'auto_draw' => true,
                'notify_winners' => true,
            ],
            [
                'title' => 'Apoio ao Time de Futebol Amador',
                'description' => 'Nosso time de futebol amador precisa de uniformes novos e equipamentos para participar do campeonato municipal. Ajude-nos a representar nossa cidade!',
                'prize_description' => 'PlayStation 5 + 2 Controles + 3 Jogos',
                'prize_image' => null,
                'price_per_ticket' => 12.00,
                'total_tickets' => 600,
                'sold_tickets' => 180,
                'draw_date' => now()->addDays(22),
                'status' => 'active',
                'category' => 'sports',
                'state' => 'Paraná',
                'city' => 'Curitiba',
                'neighborhood' => 'Batel',
                'address' => 'Rua XV de Novembro, 987',
                'zip_code' => '80020-310',
                'organizer_id' => $organizer->id,
                'featured' => false,
                'min_tickets_to_draw' => 500,
                'terms_conditions' => 'Sorteio será realizado quando atingir o número mínimo de bilhetes vendidos.',
                'contact_info' => 'WhatsApp: (11) 44444-4444 | Email: timefutebol@club.com',
                'goal_amount' => 7200.00,
                'current_amount' => 2160.00,
                'payment_methods' => ['pix'],
                'social_media_links' => [
                    'instagram' => 'https://instagram.com/timefutebol'
                ],
                'is_public' => true,
                'auto_draw' => true,
                'notify_winners' => true,
            ],
        ];

        foreach ($raffles as $raffleData) {
            Raffle::create($raffleData);
        }
    }
}
