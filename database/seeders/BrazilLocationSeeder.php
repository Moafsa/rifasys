<?php

namespace Database\Seeders;

use App\Models\BrazilCity;
use App\Models\BrazilState;
use Illuminate\Database\Seeder;

class BrazilLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Estados do Brasil
        $states = [
            // Região Norte
            ['name' => 'Acre', 'code' => 'AC', 'region' => 'Norte'],
            ['name' => 'Amapá', 'code' => 'AP', 'region' => 'Norte'],
            ['name' => 'Amazonas', 'code' => 'AM', 'region' => 'Norte'],
            ['name' => 'Pará', 'code' => 'PA', 'region' => 'Norte'],
            ['name' => 'Rondônia', 'code' => 'RO', 'region' => 'Norte'],
            ['name' => 'Roraima', 'code' => 'RR', 'region' => 'Norte'],
            ['name' => 'Tocantins', 'code' => 'TO', 'region' => 'Norte'],
            
            // Região Nordeste
            ['name' => 'Alagoas', 'code' => 'AL', 'region' => 'Nordeste'],
            ['name' => 'Bahia', 'code' => 'BA', 'region' => 'Nordeste'],
            ['name' => 'Ceará', 'code' => 'CE', 'region' => 'Nordeste'],
            ['name' => 'Maranhão', 'code' => 'MA', 'region' => 'Nordeste'],
            ['name' => 'Paraíba', 'code' => 'PB', 'region' => 'Nordeste'],
            ['name' => 'Pernambuco', 'code' => 'PE', 'region' => 'Nordeste'],
            ['name' => 'Piauí', 'code' => 'PI', 'region' => 'Nordeste'],
            ['name' => 'Rio Grande do Norte', 'code' => 'RN', 'region' => 'Nordeste'],
            ['name' => 'Sergipe', 'code' => 'SE', 'region' => 'Nordeste'],
            
            // Região Centro-Oeste
            ['name' => 'Distrito Federal', 'code' => 'DF', 'region' => 'Centro-Oeste'],
            ['name' => 'Goiás', 'code' => 'GO', 'region' => 'Centro-Oeste'],
            ['name' => 'Mato Grosso', 'code' => 'MT', 'region' => 'Centro-Oeste'],
            ['name' => 'Mato Grosso do Sul', 'code' => 'MS', 'region' => 'Centro-Oeste'],
            
            // Região Sudeste
            ['name' => 'Espírito Santo', 'code' => 'ES', 'region' => 'Sudeste'],
            ['name' => 'Minas Gerais', 'code' => 'MG', 'region' => 'Sudeste'],
            ['name' => 'Rio de Janeiro', 'code' => 'RJ', 'region' => 'Sudeste'],
            ['name' => 'São Paulo', 'code' => 'SP', 'region' => 'Sudeste'],
            
            // Região Sul
            ['name' => 'Paraná', 'code' => 'PR', 'region' => 'Sul'],
            ['name' => 'Rio Grande do Sul', 'code' => 'RS', 'region' => 'Sul'],
            ['name' => 'Santa Catarina', 'code' => 'SC', 'region' => 'Sul'],
        ];

        foreach ($states as $stateData) {
            $state = BrazilState::create($stateData);
            
            // Adicionar cidades principais para cada estado (removendo duplicatas)
            $cities = $this->getCitiesForState($stateData['code']);
            $uniqueCities = array_unique($cities);
            
            foreach ($uniqueCities as $cityName) {
                BrazilCity::create([
                    'name' => $cityName,
                    'state_id' => $state->id,
                ]);
            }
        }
    }

    private function getCitiesForState($stateCode): array
    {
        $citiesByState = [
            'AC' => ['Rio Branco', 'Cruzeiro do Sul', 'Sena Madureira', 'Tarauacá', 'Feijó'],
            'AL' => ['Maceió', 'Arapiraca', 'Palmeira dos Índios', 'Rio Largo', 'Penedo'],
            'AP' => ['Macapá', 'Santana', 'Laranjal do Jari', 'Oiapoque', 'Mazagão'],
            'AM' => ['Manaus', 'Parintins', 'Itacoatiara', 'Manacapuru', 'Coari'],
            'BA' => [
                'Salvador', 'Feira de Santana', 'Vitória da Conquista', 'Camaçari', 'Juazeiro',
                'Itabuna', 'Lauro de Freitas', 'Ilhéus', 'Jequié', 'Teixeira de Freitas',
                'Barreiras', 'Alagoinhas', 'Porto Seguro', 'Simões Filho', 'Paulo Afonso',
                'Eunápolis', 'Guanambi', 'Jacobina', 'Senhor do Bonfim', 'Valença',
                'Serrinha', 'Conceição do Coité', 'Dias d\'Ávila', 'Bom Jesus da Lapa', 'Santo Antônio de Jesus',
                'Candeias', 'Itapetinga', 'Brumado', 'Irecê', 'Livramento de Nossa Senhora',
                'Cruz das Almas', 'Mata de São João', 'Santo Amaro', 'Catu', 'Seabra',
                'Maragogipe', 'Mutuípe', 'Campo Formoso', 'Ipirá', 'Pojuca',
                'Conceição do Jacuípe', 'Amélia Rodrigues', 'Xique-Xique', 'Conde', 'Entre Rios',
                'Conceição da Feira', 'Coração de Maria', 'Feira de Santana', 'Cachoeira', 'São Francisco do Conde'
            ],
            'CE' => [
                'Fortaleza', 'Caucaia', 'Juazeiro do Norte', 'Maracanaú', 'Sobral',
                'Itapipoca', 'Maranguape', 'Iguatu', 'Crato', 'Quixadá',
                'Pacatuba', 'Aquiraz', 'Russas', 'Aracati', 'Eusébio',
                'Horizonte', 'Tianguá', 'Icó', 'Limoeiro do Norte', 'Camocim',
                'Crateús', 'Quixeramobim', 'Barbalha', 'Acaraú', 'Acopiara',
                'Granja', 'Baturité', 'Cascavel', 'Viçosa do Ceará', 'Mauriti',
                'Trairi', 'Itarema', 'Canindé', 'Pentecoste', 'Monsenhor Tabosa',
                'Tamboril', 'Itapiúna', 'Morada Nova', 'Amontada', 'Aracoiaba',
                'Beberibe', 'Caririaçu', 'Cedro', 'Coreaú', 'Fortim',
                'Guaraciaba do Norte', 'Icapuí', 'Irauçuba', 'Jaguaretama', 'Jaguaribara',
                'Jucás', 'Massapê', 'Milagres', 'Mombaça', 'Morrinhos'
            ],
            'DF' => ['Brasília', 'Taguatinga', 'Ceilândia', 'Samambaia', 'Planaltina'],
            'ES' => ['Vitória', 'Vila Velha', 'Cariacica', 'Serra', 'Cachoeiro de Itapemirim'],
            'GO' => [
                'Goiânia', 'Aparecida de Goiânia', 'Anápolis', 'Rio Verde', 'Luziânia',
                'Valparaíso de Goiás', 'Trindade', 'Formosa', 'Novo Gama', 'Senador Canedo',
                'Itumbiara', 'Catalão', 'Jataí', 'Santo Antônio do Descoberto', 'Mineiros',
                'Caldas Novas', 'Goianésia', 'Planaltina', 'Goiatuba', 'Cidade Ocidental',
                'Santa Helena de Goiás', 'Cristalina', 'Morrinhos', 'Iporá', 'Chapadão do Céu',
                'Itapuranga', 'Pires do Rio', 'Bom Jesus de Goiás', 'Ceres', 'Niquelândia',
                'Porangatu', 'São Luís de Montes Belos', 'Goiás', 'Itaberaí', 'Inhumas',
                'Nerópolis', 'Bela Vista de Goiás', 'Abadiânia', 'Alexânia', 'Cocalzinho de Goiás',
                'Corumbá de Goiás', 'Flores de Goiás', 'Guapó', 'Hidrolândia', 'Itaguari',
                'Itaguaru', 'Jesúpolis', 'Leopoldo de Bulhões', 'Nova Veneza', 'Orizona',
                'Palmeiras de Goiás', 'Aragarças', 'Barro Alto', 'Brasilândia de Minas', 'Cachoeira Dourada'
            ],
            'MA' => ['São Luís', 'Imperatriz', 'São José de Ribamar', 'Timon', 'Caxias'],
            'MT' => ['Cuiabá', 'Várzea Grande', 'Rondonópolis', 'Sinop', 'Tangará da Serra'],
            'MS' => ['Campo Grande', 'Dourados', 'Três Lagoas', 'Corumbá', 'Ponta Porã'],
            'MG' => [
                'Belo Horizonte', 'Uberlândia', 'Contagem', 'Juiz de Fora', 'Betim',
                'Montes Claros', 'Ribeirão das Neves', 'Uberaba', 'Governador Valadares', 'Ipatinga',
                'Sete Lagoas', 'Divinópolis', 'Santa Luzia', 'Ibirité', 'Poços de Caldas',
                'Patos de Minas', 'Pouso Alegre', 'Teófilo Otoni', 'Barbacena', 'Sabará',
                'Vespasiano', 'Conselheiro Lafaiete', 'Ituiutaba', 'Passos', 'Coronel Fabriciano',
                'Araguari', 'Muriaé', 'Itabira', 'Araxá', 'Lavras',
                'Ubá', 'Nova Lima', 'Caratinga', 'Patrocínio', 'Manhuaçu',
                'Viçosa', 'Formiga', 'Esmeraldas', 'João Monlevade', 'Três Corações',
                'Timóteo', 'Varginha', 'São João del Rei', 'Pará de Minas', 'Unaí',
                'Januária', 'Curvelo', 'Alfenas', 'Ouro Preto', 'Mariana',
                'Diamantina', 'São Lourenço', 'Pirapora', 'Caxambu', 'Monte Carmelo'
            ],
            'PA' => ['Belém', 'Ananindeua', 'Santarém', 'Marabá', 'Parauapebas'],
            'PB' => ['João Pessoa', 'Campina Grande', 'Santa Rita', 'Patos', 'Bayeux'],
            'PR' => [
                'Curitiba', 'Londrina', 'Maringá', 'Ponta Grossa', 'Cascavel',
                'São José dos Pinhais', 'Foz do Iguaçu', 'Colombo', 'Guarapuava', 'Paranaguá',
                'Araucária', 'Toledo', 'Apucarana', 'Pinhais', 'Campo Largo',
                'Almirante Tamandaré', 'Umuarama', 'Piraquara', 'Cambé', 'Fazenda Rio Grande',
                'Sarandi', 'Paranavaí', 'Rolândia', 'Matinhos', 'Campo Mourão',
                'Pontal do Paraná', 'Lapa', 'Telêmaco Borba', 'Irati', 'União da Vitória',
                'Guaratuba', 'Pato Branco', 'Francisco Beltrão', 'Medianeira', 'Dois Vizinhos',
                'Palmas', 'Cianorte', 'Maringá', 'Londrina', 'Cascavel',
                'Ponta Grossa', 'Curitiba', 'São José dos Pinhais', 'Colombo', 'Guarapuava',
                'Foz do Iguaçu', 'Araucária', 'Toledo', 'Apucarana', 'Pinhais'
            ],
            'PE' => [
                'Recife', 'Jaboatão dos Guararapes', 'Olinda', 'Caruaru', 'Petrolina',
                'Garanhuns', 'Vitória de Santo Antão', 'Igarassu', 'São Lourenço da Mata', 'Cabo de Santo Agostinho',
                'Abreu e Lima', 'Ipojuca', 'Camaragibe', 'Paulista', 'Carpina',
                'Gravatá', 'Bezerros', 'Limoeiro', 'Serra Talhada', 'Araripina',
                'Goiana', 'Escada', 'Moreno', 'São José da Coroa Grande', 'Palmares',
                'Belo Jardim', 'Surubim', 'Bom Conselho', 'Afogados da Ingazeira', 'Pesqueira',
                'Timbaúba', 'Lagoa Grande', 'Bodocó', 'Floresta', 'Exu',
                'Ouricuri', 'Santa Cruz do Capibaribe', 'Toritama', 'Santa Maria da Boa Vista', 'Salgueiro',
                'Serrita', 'Custódia', 'Sertânia', 'Arcoverde', 'Buíque',
                'Bodocó', 'Trindade', 'Cedro', 'Mirandiba', 'São José do Belmonte'
            ],
            'PI' => ['Teresina', 'Parnaíba', 'Picos', 'Piripiri', 'Floriano'],
            'RJ' => [
                'Rio de Janeiro', 'São Gonçalo', 'Duque de Caxias', 'Nova Iguaçu', 'Niterói',
                'Belford Roxo', 'São João de Meriti', 'Campos dos Goytacazes', 'Petrópolis', 'Volta Redonda',
                'Magé', 'Itaboraí', 'Macaé', 'Cabo Frio', 'Angra dos Reis',
                'Nova Friburgo', 'Barra Mansa', 'Teresópolis', 'Mesquita', 'Maricá',
                'Nilópolis', 'Queimados', 'Itaguaí', 'Japeri', 'Seropédica',
                'Resende', 'Barra do Piraí', 'Paraíba do Sul', 'Valença', 'Vassouras',
                'Três Rios', 'Nova Iguaçu', 'São João de Meriti', 'Belford Roxo', 'Mesquita',
                'Queimados', 'Japeri', 'Seropédica', 'Itaguaí', 'Maricá',
                'Paracambi', 'Engenheiro Paulo de Frontin', 'Mendes', 'Miguel Pereira', 'Paty do Alferes',
                'Vassouras', 'Barra do Piraí', 'Valença', 'Paraíba do Sul', 'Três Rios',
                'Resende', 'Itatiaia', 'Quatis', 'Porto Real', 'Pinheiral'
            ],
            'RN' => ['Natal', 'Mossoró', 'Parnamirim', 'São Gonçalo do Amarante', 'Macaíba'],
            'RS' => [
                'Porto Alegre', 'Caxias do Sul', 'Pelotas', 'Canoas', 'Santa Maria',
                'Gravataí', 'Viamão', 'Novo Hamburgo', 'São Leopoldo', 'Rio Grande',
                'Alvorada', 'Passo Fundo', 'Sapucaia do Sul', 'Uruguaiana', 'Santa Cruz do Sul',
                'Cachoeirinha', 'Bagé', 'Bento Gonçalves', 'Erechim', 'Guaíba',
                'Cachoeira do Sul', 'Santana do Livramento', 'Ijuí', 'Sapiranga', 'São Gabriel',
                'Camaquã', 'Esteio', 'Lajeado', 'Alegrete', 'Vacaria',
                'Tramandaí', 'Torres', 'Osório', 'Capão da Canoa', 'Gramado',
                'Canela', 'Garibaldi', 'Farroupilha', 'Flores da Cunha', 'Nova Petrópolis',
                'São Sebastião do Caí', 'Montenegro', 'Triunfo', 'São Jerônimo', 'Charqueadas',
                'Arroio dos Ratos', 'Butiá', 'Tapes', 'Barra do Ribeiro', 'Sentinela do Sul',
                'Mariana Pimentel', 'Eldorado do Sul', 'Taquara', 'São Lourenço do Sul', 'Canguçu',
                'Cachoeira do Sul', 'São Sepé', 'Caçapava do Sul', 'Rosário do Sul', 'São Borja',
                'Sant\'Ana do Livramento', 'Jaguarão', 'Dom Pedrito', 'Livramento', 'Quaraí',
                'Itaqui', 'Maçambará', 'São Gabriel', 'Alegrete', 'Barra do Quaraí'
            ],
            'RO' => ['Porto Velho', 'Ji-Paraná', 'Ariquemes', 'Vilhena', 'Cacoal'],
            'RR' => ['Boa Vista', 'Rorainópolis', 'Caracaraí', 'Alto Alegre', 'Mucajaí'],
            'SC' => [
                'Florianópolis', 'Joinville', 'Blumenau', 'São José', 'Criciúma',
                'Chapecó', 'Itajaí', 'Lages', 'Jaraguá do Sul', 'Palhoça',
                'Balneário Camboriú', 'Brusque', 'Tubarão', 'São Bento do Sul', 'Caxias do Sul',
                'Navegantes', 'São João Batista', 'Gaspar', 'Indaial', 'Camboriú',
                'Rio do Sul', 'Araranguá', 'Caçador', 'Concórdia', 'Itapema',
                'Imbituba', 'Laguna', 'São Francisco do Sul', 'Biguaçu', 'Tijucas',
                'Bombinhas', 'Governador Celso Ramos', 'Garopaba', 'Imaruí', 'Imbituba',
                'Jaguaruna', 'Orleans', 'Sangão', 'Treze de Maio', 'Turvo',
                'Urussanga', 'Cocal do Sul', 'Forquilhinha', 'Içara', 'Morro da Fumaça',
                'Nova Veneza', 'Siderópolis', 'Balneário Rincão', 'Balneário Gaivota', 'Balneário Arroio do Silva'
            ],
            'SP' => [
                'São Paulo', 'Guarulhos', 'Campinas', 'São Bernardo do Campo', 'Santo André',
                'Osasco', 'Ribeirão Preto', 'Sorocaba', 'Mauá', 'São José dos Campos',
                'Mogi das Cruzes', 'Diadema', 'Jundiaí', 'Carapicuíba', 'Piracicaba',
                'Bauru', 'Itaquaquecetuba', 'Franca', 'São Vicente', 'Guarujá',
                'Taubaté', 'Embu das Artes', 'Barueri', 'Praia Grande', 'Suzano',
                'Taboão da Serra', 'Sumaré', 'Marília', 'Americana', 'Araraquara',
                'Jacareí', 'Presidente Prudente', 'Hortolândia', 'Rio Claro', 'Araçatuba',
                'Indaiatuba', 'Cotia', 'Itapevi', 'São Caetano do Sul', 'Ferraz de Vasconcelos',
                'Francisco Morato', 'Itapecerica da Serra', 'Itu', 'Bragança Paulista', 'Pindamonhangaba',
                'São José do Rio Preto', 'Araras', 'Cubatão', 'Mogi Guaçu', 'Sertãozinho',
                'Jandira', 'Birigui', 'Ribeirão Pires', 'Ubatuba', 'Valinhos',
                'Caraguatatuba', 'Itatiba', 'Barretos', 'Botucatu', 'Santos'
            ],
            'SE' => ['Aracaju', 'Nossa Senhora do Socorro', 'Lagarto', 'Itabaiana', 'São Cristóvão'],
            'TO' => ['Palmas', 'Araguaína', 'Gurupi', 'Porto Nacional', 'Paraíso do Tocantins'],
        ];

        return $citiesByState[$stateCode] ?? [];
    }
}
