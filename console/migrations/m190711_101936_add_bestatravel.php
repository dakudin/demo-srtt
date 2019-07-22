<?php

use yii\db\Migration;

class m190711_101936_add_bestatravel extends Migration
{
    public function safeUp()
    {
        $this->execute('INSERT INTO quote_company SET id=10, image="best_at_travel.png", company_name="Best At Travel", method_name="createQuoteBestAtTravel", info="We`re a passionate family-run travel company with over 30 years` experience in creating tailor-made luxury holidays and tours around the world. From the moment you get in touch with our Best at Travel experts to the time you return from your holiday you can relax and have peace of mind knowing you`re travelling with a certified ABTA and ATOL certified company, guaranteeing complete financial protection."');

        $this->batchInsert('quote_company_category',
            ['quote_company_id', 'enquiry_category_id'],
            [
                [10,2],
                [10,3],
            ]
        );

        $this->batchInsert('quote_company_destination',
            ['quote_company_id', 'destination_value', 'geo_country', 'geo_country_code', 'geo_city', 'geo_region'],
            [
                [10, 'Agadir (AGA), Morocco, Africa', 'Morocco', 'MA', 'Agadir', ''],
                [10, 'Casablanca (CAS), Morocco, Africa', 'Morocco', 'MA', 'Casablanca', ''],
                [10, 'Essaouira (RAK), Morocco, Africa', 'Morocco', 'MA', 'Essaouira', ''],
                [10, 'Marrakech (RAK), Morocco, Africa', 'Morocco', 'MA', 'Marrakech', ''],
                [10, 'Cape Town (CPT), South Africa, Africa', 'South Africa', 'ZA', 'Cape Town', ''],
                [10, 'Franschhoek (CPT), Cape Winelands, South Africa, Africa', 'South Africa', 'ZA', 'Franschhoek', ''],
                [10, 'Stellenbosch (CPT), Cape Winelands, South Africa, Africa', 'South Africa', 'ZA', 'Stellenbosch', ''],
                [10, 'Wellington (CPT), Cape Winelands, South Africa, Africa', 'South Africa', 'ZA', 'Wellington', ''],
                [10, 'Zanzibar (ZNZ), Africa', 'Tanzania', 'TZ', 'Zanzibar', ''],
                [10, 'Siem Reap (REP), Cambodia, Asia', 'Cambodia', 'KH', 'Siem Reap', 'Siem Reap'],
                [10, 'Sihanoukville (KOS), Cambodia, Asia', 'Cambodia', 'KH', 'Sihanoukville', ''],
                [10, 'Phnom Penh, Sihanoukville (PNH), Cambodia, Asia', 'Cambodia', 'KH', 'Phnom Penh', ''],
                [10, 'Hong Kong (HKG), Asia', 'Hong Kong', 'HK', 'Hong Kong', ''],
                [10, 'Bali (DPS), Indonesia, Asia', 'Indonesia', 'ID', 'Bali', 'Bali'],
                [10, 'Kyoto (OSA), Japan, Asia', 'Japan', 'JP', '', 'Kyoto'],
                [10, 'Tokyo (TYO), Japan, Asia', 'Japan', 'JP', 'Tokyo', 'Tokyo'],
                [10, 'Kuala Lumpur (KUL), Malaysia, Asia', 'Malaysia', 'MY', 'Kuala Lumpur', 'Kuala Lumpur'],
                [10, 'Langkawi (LGK), Malaysia, Asia', 'Malaysia', 'MY', 'Langkawi', ''],
                [10, 'Terengganu, More Malaysia Destinations (TGG), Malaysia, Asia', 'Malaysia', 'MY', '', 'Terengganu'],
                [10, 'Pangkor (KUL), Malaysia, Asia', 'Malaysia', 'MY', 'Pangkor', ''],
                [10, 'Penang (PEN), Malaysia, Asia', 'Malaysia', 'MY', 'Penang', ''],
                [10, 'Singapore (SIN), Asia', 'Singapore', 'SG', 'Singapore', ''],
                [10, 'Bangkok (BKK), Thailand, Asia', 'Thailand', 'TH', 'Bangkok', ''],
                [10, 'Hua Hin (BKK), Thailand, Asia', 'Thailand', 'TH', 'Hua Hin', ''],
                [10, 'Pattaya (BKK), Thailand, Asia', 'Thailand', 'TH', 'Pattaya', ''],
                [10, 'Phuket (HKT), Thailand, Asia', 'Thailand', 'TH', 'Phuket', 'Phuket'],
                [10, 'Phan Thiet, South Vietnam (SGN), Vietnam, Asia', 'Vietnam', 'VN', 'Phan Thiet', ''],
                [10, 'Nha Trang, South Vietnam (CXR), Vietnam, Asia', 'Vietnam', 'VN', 'Nha Trang', ''],
                [10, 'Phu Quoc, South Vietnam (PQC), Vietnam, Asia', 'Vietnam', 'VN', 'Phu Quoc', ''],
                [10, 'Montreal (YUL), Canada', 'Canada', 'CA', 'Montreal', ''],
                [10, 'Halifax, Nova Scotia (YHZ), Canada', 'Canada', 'CA', 'Halifax', ''],
                [10, 'Ottawa (YOW), Canada', 'Canada', 'CA', 'Ottawa', ''],
                [10, 'Toronto (YYZ), Canada', 'Canada', 'CA', 'Toronto', ''],
                [10, 'Banff (YYC), Canada', 'Canada', 'CA', 'Banff', ''],
                [10, 'Calgary (YYC), Canada', 'Canada', 'CA', 'Calgary', ''],
                [10, 'Jasper (YJA), Canada', 'Canada', 'CA', 'Jasper', ''],
                [10, 'Lake Louise (YYC), Canada', 'Canada', 'CA', 'Lake Louise', ''],
                [10, 'Vancouver (YVR), Canada', 'Canada', 'CA', 'Vancouver', ''],
                [10, 'Tofino, Vancouver Island (YYJ), Canada', 'Canada', 'CA', 'Tofino', ''],
                [10, 'Campbell River, Vancouver (YVR), Canada', 'Canada', 'CA', 'Campbell River', ''],
                [10, 'Victoria, Vancouver Island (YYJ), Canada', 'Canada', 'CA', 'Victoria', ''],
                [10, 'Courtenay, Vancouver Island (YYJ), Canada', 'Canada', 'CA', 'Courtenay', ''],
                [10, 'Port Hardy, Vancouver (YVR), Canada', 'Canada', 'CA', 'Port Hardy', ''],
                [10, 'Nassau, Bahamas (NAS), Caribbean', 'Bahamas', 'BS', 'Nassau', ''],
                [10, 'Havana (HAV), Cuba, Caribbean', 'Cuba', 'CU', 'Havana', ''],
                [10, 'Trinidad (HAV), Cuba, Caribbean', 'Cuba', 'CU', 'Trinidad', ''],
                [10, 'Varadero (HAV), Cuba, Caribbean', 'Cuba', 'CU', 'Varadero', ''],
                [10, 'Negril, Jamaica (MBJ), Caribbean', 'Jamaica', 'JM', 'Negril', ''],
                [10, 'Ocho Rios, Jamaica (MBJ), Caribbean', 'Jamaica', 'JM', 'Ocho Rios', ''],
                [10, 'Montego Bay, Jamaica (MBJ), Caribbean', 'Jamaica', 'JM', 'Montego Bay', ''],
                [10, 'Runaway Bay, Jamaica (MBJ), Caribbean', 'Jamaica', 'JM', 'Runaway Bay', ''],
                [10, 'Trelawny, Jamaica (MBJ), Caribbean', 'Jamaica', 'JM', '', 'Trelawny'],
                [10, 'Whitehouse, Jamaica (MBJ), Caribbean', 'Jamaica', 'JM', 'Whitehouse', ''],
                [10, 'Port Antonio, Jamaica (MBJ), Caribbean', 'Jamaica', 'JM', 'Port Antonio', ''],
                [10, 'Soufriere, Saint Lucia (UVF), Caribbean', 'Saint Lucia', 'LC', 'Soufrière', 'Soufriere'],
                [10, 'Castries, Saint Lucia (UVF), Caribbean', 'Saint Lucia', 'LC', 'Castries', 'Castries'],
                [10, 'Gros Islet, Saint Lucia (UVF), Caribbean', 'Saint Lucia', 'LC', 'Gros Islet', ''],
                [10, 'Vieux Fort, Saint Lucia (UVF), Caribbean', 'Saint Lucia', 'LC', 'Vieux Fort', ''],
                [10, 'Marigot Bay, Saint Lucia (UVF), Caribbean', 'Saint Lucia', 'LC', 'Marigot Bay', ''],
                [10, 'Grenadines (BGI), Caribbean', 'Saint Vincent and the Grenadines', 'VC', '', 'Grenadines'],
                [10, 'Guanacaste, Costa Rica, Central & South America', 'Costa Rica', 'CR', '', 'Guanacaste'],
                [10, 'Nosara, Costa Rica, Central & South America', 'Costa Rica', 'CR', 'Nosara', ''],
                [10, 'Tortuguero, Costa Rica, Central & South America', 'Costa Rica', 'CR', 'Tortuguero', ''],
                [10, 'Monteverde, Costa Rica, Central & South America', 'Costa Rica', 'CR', 'Monteverde', ''],
                [10, 'Salzburg (SZG), Austria, Europe', 'Austria', 'AT', 'Salzburg', 'Salzburg'],
                [10, 'Vienna (VIE), Austria, Europe', 'Austria', 'AT', 'Vienna', ''],
                [10, 'Dubrovnik (DBV), Croatia, Europe', 'Croatia', 'HR', 'Dubrovnik', ''],
                [10, 'Hvar (SPU), Croatia, Europe', 'Croatia', 'HR', 'Hvar', ''],
                [10, 'Rovinj (PUY), Croatia, Europe', 'Croatia', 'HR', 'Rovinj', ''],
                [10, 'Sibenik (SPU), Croatia, Europe', 'Croatia', 'HR', 'Sibenik', ''],
                [10, 'Split (SPU), Croatia, Europe', 'Croatia', 'HR', 'Split', ''],
                [10, 'Zagreb (ZAG), Croatia, Europe', 'Croatia', 'HR', 'Zagreb', ''],
                [10, 'Prague (PRG), Czech Republic, Europe', 'Czechia', 'CZ', 'Prague', ''],
                [10, 'Corfu (CFU), Greece, Europe', 'Greece', 'GR', 'Corfu', ''],
                [10, 'Folegandros (JTR), Greece, Europe', 'Greece', 'GR', 'Folégandros', ''],
                [10, 'Kos (KGS), Greece, Europe', 'Greece', 'GR', 'Kos', ''],
                [10, 'Mykonos (JMK), Greece, Europe', 'Greece', 'GR', 'Mýkonos', ''],
                [10, 'Serifos (ATH), Greece, Europe', 'Greece', 'GR', 'Sérifos', ''],
                [10, 'Skiathos (JSI), Greece, Europe', 'Greece', 'GR', 'Skíathos', ''],
                [10, 'Zakynthos  (ZTH), Greece, Europe', 'Greece', 'GR', 'Zákynthos', ''],
                [10, 'Budapest (BUD), Hungary, Europe', 'Hungary', 'HU', 'Budapest', 'Budapest'],
                [10, 'Florence (PSA), Italy, Europe', 'Italy', 'IT', 'Florence', ''],
                [10, 'Puglia (BRI), Italy, Europe', 'Italy', 'IT', '', 'Puglia'],
                [10, 'Rome (FCO), Italy, Europe', 'Italy', 'IT', 'Rome', ''],
                [10, 'Venice (VCE), Italy, Europe', 'Italy', 'IT', 'Venice', ''],
                [10, 'Amsterdam (AMS), Netherlands, Europe', 'Netherlands', 'NL', 'Amsterdam', ''],
                [10, 'Lisbon (LIS), Portugal, Europe', 'Portugal', 'PT', 'Lisbon', ''],
                [10, 'Porto (OPO), Portugal, Europe', 'Portugal', 'PT', 'Porto', 'Porto'],
                [10, 'Estepona, Andalucia (AGP), Spain, Europe', 'Spain', 'ES', 'Estepona', ''],
                [10, 'Seville, Andalucia (SVQ), Spain, Europe', 'Spain', 'ES', 'Seville', ''],
                [10, 'Marbella, Andalucia (AGP), Spain, Europe', 'Spain', 'ES', 'Marbella', ''],
                [10, 'Granada, Andalucia (AGP), Spain, Europe', 'Spain', 'ES', 'Granada', ''],
                [10, 'Cordoba, Andalucia (SVQ), Spain, Europe', 'Spain', 'ES', 'Córdoba', ''],
                [10, 'Andalucia (AGP), Spain, Europe', 'Spain', 'ES', '', 'Andalucia'],
                [10, 'Barcelona (BCN), Spain, Europe', 'Spain', 'ES', 'Barcelona', ''],
                [10, 'Ibiza (IBZ), Spain, Europe', 'Spain', 'ES', 'Ibiza', ''],
                [10, 'Bodrum (BJV), Turkey, Europe', 'Turkey', 'TR', 'Bodrum', ''],
                [10, 'Datca (DLM), Turkey, Europe', 'Turkey', 'TR', 'Datça', ''],
                [10, 'Fethiye (DLM), Turkey, Europe', 'Turkey', 'TR', 'Fethiye', ''],
                [10, 'Cancun (CUN), Mexico', 'Mexico', 'MX', 'Cancún', ''],
                [10, 'Cozumel, Riviera Maya (CUN), Mexico', 'Mexico', 'MX', 'Cozumel', ''],
                [10, 'Tulum (CUN), Mexico', 'Mexico', 'MX', 'Tulum', ''],
                [10, 'Abu Dhabi (AUH), Middle East', 'United Arab Emirates', 'AE', 'Abu Dhabi', 'Abu Dhabi'],
                [10, 'Ajman, Dubai (DXB), Middle East', 'United Arab Emirates', 'AE', '', 'Ajman'],
                [10, 'Dubai (DXB), Middle East', 'United Arab Emirates', 'AE', 'Dubai', 'Dubai'],
                [10, 'Ras Al Khaimah, Dubai (DXB), Middle East', 'United Arab Emirates', 'AE', '', 'Ras Al Khaimah'],
                [10, 'Fujairah, Dubai (DXB), Middle East', 'United Arab Emirates', 'AE', '', 'Fujairah'],
                [10, 'Amman, Amman (AMM), Jordan, Middle East', 'Hashemite Kingdom of Jordan', 'JO', '', 'Amman'],
                [10, 'Petra, Petra (AMM), Jordan, Middle East', 'Hashemite Kingdom of Jordan', 'JO', 'Petra', ''],
                [10, 'Muscat (MCT), Oman, Middle East', 'Oman', 'OM', 'Muscat', ''],
                [10, 'Anaheim (LAX), California, USA', 'United States', 'US', 'Anaheim', ''],
                [10, 'Stateline, Lake Tahoe (RNO), California, USA', 'United States', 'US', 'Stateline', ''],
                [10, 'Incline Village, Lake Tahoe (IV1), California, USA', 'United States', 'US', 'Incline Village', ''],
                [10, 'South Lake Tahoe, Lake Tahoe (TVL), California, USA', 'United States', 'US', 'South Lake Tahoe', ''],
                [10, 'Beverly Hills (LAX), Los Angeles, California, USA', 'United States', 'US', 'Beverly Hills', ''],
                [10, 'Hollywood (LAX), Los Angeles, California, USA', 'United States', 'US', 'Hollywood', ''],
                [10, 'Santa Monica (LAX), Los Angeles, California, USA', 'United States', 'US', 'Santa Monica', ''],
                [10, 'West Hollywood (LAX), Los Angeles, California, USA', 'United States', 'US', 'West Hollywood', ''],
                [10, 'San Luis Obispo, Pacifc Coast Highway (CSL), California, USA', 'United States', 'US', 'San Luis Obispo', ''],
                [10, 'Pismo Beach, Pacifc Coast Highway (PC1), California, USA', 'United States', 'US', 'Pismo Beach', ''],
                [10, 'Morro Bay, Pacifc Coast Highway (LAX), California, USA', 'United States', 'US', 'Morro Bay', ''],
                [10, 'Cambria, Pacifc Coast Highway (SFO), California, USA', 'United States', 'US', 'Cambria', ''],
                [10, 'Carmel, Monterey (CC3), California, USA', 'United States', 'US', 'Carmel', ''],
                [10, 'Santa Cruz, Monterey (SC1), California, USA', 'United States', 'US', 'Santa Cruz', ''],
                [10, 'Monterey (SFO), California, USA', 'United States', 'US', 'Monterey', ''],
                [10, 'Big Sur, Monterey (MRY), California, USA', 'United States', 'US', 'Big Sur', ''],
                [10, 'Santa Barbara, Santa Barbara (SBA), California, USA', 'United States', 'US', 'Santa Barbara', ''],
                [10, 'Monterey (SFO), Pacific Coast HIghway, California, USA', 'United States', 'US', 'Monterey', ''],
                [10, 'Palm Springs (PSP), California, USA', 'United States', 'US', 'Palm Springs', ''],
                [10, 'San Diego, San Diego (SAN), California, USA', 'United States', 'US', 'San Diego', ''],
                [10, 'San Francisco (SFO), California, USA', 'United States', 'US', 'San Francisco', ''],
                [10, 'Sausalito, San Francisco (SFO), California, USA', 'United States', 'US', 'Sausalito', ''],
                [10, 'Huntington Beach, Southern California Beaches (LAX), California, USA', 'United States', 'US', 'Huntington Beach', ''],
                [10, 'Newport Beach, Southern California Beaches (LAX), California, USA', 'United States', 'US', 'Newport Beach', ''],
                [10, 'Laguna Beach, Southern California Beaches (LAX), California, USA', 'United States', 'US', 'Laguna Beach', ''],
                [10, 'Boston (BOS), USA', 'United States', 'US', 'Boston', ''],
                [10, 'Chicago (ORD), USA', 'United States', 'US', 'Chicago', ''],
                [10, 'Woodstock, New England (BO6), USA', 'United States', 'US', 'Woodstock', ''],
                [10, 'Hyannis, New England (BOS), USA', 'United States', 'US', 'Hyannis', ''],
                [10, 'Chatham, New England (CYM), USA', 'United States', 'US', 'Chatham', ''],
                [10, 'Sandwich, New England (BOS), USA', 'United States', 'US', 'Sandwich', ''],
                [10, 'Jackson (New Hampshire), New England (BO4), USA', 'United States', 'US', 'Jackson', ''],
                [10, 'Provincetown, New England (PVC), USA', 'United States', 'US', 'Provincetown', ''],
                [10, 'Kennebunkport, New England (KM1), USA', 'United States', 'US', 'Kennebunkport', ''],
                [10, 'Newport (Rhode Island), New England (NPT), USA', 'United States', 'US', 'Newport', ''],
                [10, 'Portland (Maine), New England (PWM), USA', 'United States', 'US', 'Portland', ''],
                [10, 'Falmouth, New England (FMH), USA', 'United States', 'US', 'Falmouth', ''],
                [10, 'Stowe, New England (MVL), USA', 'United States', 'US', 'Stowe', ''],
                [10, 'Bar Harbor, New England (AN1), USA', 'United States', 'US', 'Bar Harbor', ''],
                [10, 'Mystic, New England (BOS), USA', 'United States', 'US', 'Mystic', ''],
                [10, 'Philadelphia (PHL), USA', 'United States', 'US', 'Philadelphia', ''],
                [10, 'Vero Beach, East Coast Beaches (VRB), Florida, USA', 'United States', 'US', 'Vero Beach', ''],
                [10, 'Cocoa Beach, East Coast Beaches (MCO), Florida, USA', 'United States', 'US', 'Cocoa Beach', ''],
                [10, 'Fort Lauderdale, East Coast Beaches (FLL), Florida, USA', 'United States', 'US', 'Fort Lauderdale', ''],
                [10, 'West Palm Beach, East Coast Beaches (PBI), Florida, USA', 'United States', 'US', 'West Palm Beach', ''],
                [10, 'Daytona Beach, East Coast Beaches (DAB), Florida, USA', 'United States', 'US', 'Daytona Beach', ''],
                [10, 'Key West, Florida Keys (EYW), Florida, USA', 'United States', 'US', 'Key West', ''],
                [10, 'Islamorada, Florida Keys (MIA), Florida, USA', 'United States', 'US', 'Islamorada', ''],
                [10, 'Duck Key, Florida Keys (MIA), Florida, USA', 'United States', 'US', 'Duck Key', ''],
                [10, 'Marathon, Florida Keys (MTH), Florida, USA', 'United States', 'US', 'Marathon', ''],
                [10, 'Key Largo, Florida Keys (MIA), Florida, USA', 'United States', 'US', 'Key Largo', ''],
                [10, 'Clearwater, Gulf Coast Beaches (TPA), Florida, USA', 'United States', 'US', 'Clearwater', ''],
                [10, 'Naples, Gulf Coast Beaches (APF), Florida, USA', 'United States', 'US', 'Naples', ''],
                [10, 'Fort Myers Beach, Gulf Coast Beaches (TPA), Florida, USA', 'United States', 'US', 'Fort Myers Beach', ''],
                [10, 'Miami (MIA), Florida, USA', 'United States', 'US', 'Miami', ''],
                [10, 'Orlando (MCO), Florida, USA', 'United States', 'US', 'Orlando', ''],
                [10, 'Las Vegas (LAS), USA', 'United States', 'US', 'Las Vegas', ''],
                [10, 'Brooklyn (NYC), New York City, USA', 'United States', 'US', 'Brooklyn', ''],
                [10, 'Manhattan (NYC), New York City, USA', 'United States', 'US', 'Manhattan', ''],
                [10, 'Memphis (MEM), USA', 'United States', 'US', 'Memphis', ''],
                [10, 'Nashville (BNA), USA', 'United States', 'US', 'Nashville', ''],
                [10, 'New Orleans (MSY), USA', 'United States', 'US', 'New Orleans', ''],
                [10, 'Austin (AUS), Texas, USA', 'United States', 'US', 'Austin', ''],
                [10, 'Dallas (DFW), Texas, USA', 'United States', 'US', 'Dallas', ''],
                [10, 'Fort Worth, Dallas (DFW), Texas, USA', 'United States', 'US', 'Fort Worth', ''],
                [10, 'Houston (IAH), Texas, USA', 'United States', 'US', 'Houston', ''],
                [10, 'San Antonio (SAT), Texas, USA', 'United States', 'US', 'San Antonio', ''],
                [10, 'Kota Kinabalu (BKI), Borneo, Malaysia, Asia', 'Malaysia', 'MY', 'Kota Kinabalu', ''],
                [10, 'Nova Scotia (YHZ), Canada', 'Canada', 'CA', '', 'Nova Scotia'],
                [10, 'Baja California (SJD), Mexico', 'Mexico', 'MX', 'Baja California', 'Baja California'],
                [10, 'Salalah (SLL), Oman, Middle East', 'Oman', 'OM', 'Salalah', ''],
                [10, 'New England (BOS), USA', 'United States', 'US', 'New England', ''],
                [10, 'Fiji (NAN), Australasia', 'Fiji', 'FJ', '', ''],
                [10, 'Anguilla (SXM), Caribbean', 'Anguilla', 'AI', '', ''],
                [10, 'Aruba (AUA), Caribbean', 'Aruba', 'AW', '', ''],
                [10, 'Bahamas (NAS), Caribbean', 'Bahamas', 'BS', '', ''],
                [10, 'Barbados (BGI), Caribbean', 'Barbados', 'BB', '', ''],
                [10, 'Bermuda (BDA), Caribbean', 'Bermuda', 'BM', '', ''],
                [10, 'British Virgin Islands (EIS), Caribbean', 'British Virgin Islands', 'VG', '', ''],
                [10, 'Cayman Islands (GCM), Caribbean', 'Cayman Islands', 'KY', '', ''],
                [10, 'Saint Lucia (UVF), Caribbean', 'Saint Lucia', 'LC', '', ''],
                [10, 'Cyprus (PFO), Europe', 'Cyprus', 'CY', '', ''],
                [10, 'Grenada (GND), Caribbean', 'Grenada', 'GD', '', ''],
                [10, 'Jamaica (MBJ), Caribbean', 'Jamaica', 'JM', '', ''],
            ]
        );

        $this->addColumn('dict_airport', 'bestattravel_value',  $this->string(3));

        $this->execute("UPDATE dict_airport SET bestattravel_value='LHR' WHERE id=27"); // London Heathrow
        $this->execute("UPDATE dict_airport SET bestattravel_value='LGW' WHERE id=5"); // London Gatwick
        $this->execute("UPDATE dict_airport SET bestattravel_value='LCY' WHERE id=44"); // London City
        $this->execute("UPDATE dict_airport SET bestattravel_value='ABZ' WHERE id=42"); // Aberdeen
        $this->execute("UPDATE dict_airport SET bestattravel_value='BFS' WHERE id=30"); // Belfast
        $this->execute("UPDATE dict_airport SET bestattravel_value='BHD' WHERE id=39"); // Belfast City
        $this->execute("UPDATE dict_airport SET bestattravel_value='BHX' WHERE id=20"); // Birmingham
        $this->execute("UPDATE dict_airport SET bestattravel_value='EDI' WHERE id=6"); // Edinburgh
        $this->execute("UPDATE dict_airport SET bestattravel_value='GLA' WHERE id=7"); // Glasgow
        $this->execute("UPDATE dict_airport SET bestattravel_value='LBA' WHERE id=19"); // Leeds / Bradford
        $this->execute("UPDATE dict_airport SET bestattravel_value='MAN' WHERE id=9"); // Manchester
        $this->execute("UPDATE dict_airport SET bestattravel_value='NCL' WHERE id=11"); // Newcastle
        $this->execute("UPDATE dict_airport SET bestattravel_value='STN' WHERE id=21"); // London Stansted
        $this->execute("UPDATE dict_airport SET bestattravel_value='BRS' WHERE id=16"); // Bristol
        $this->execute("UPDATE dict_airport SET bestattravel_value='CWL' WHERE id=3"); // Cardiff
        $this->execute("UPDATE dict_airport SET bestattravel_value='EXT' WHERE id=13"); // Exeter
        $this->execute("UPDATE dict_airport SET bestattravel_value='SOU' WHERE id=26"); // Southampton

        $this->execute("INSERT INTO dict_airport SET id=45, name='Humberside', bestattravel_value='HUY'"); // Humberside
        $this->execute("INSERT INTO dict_airport SET id=46, name='Norwich', bestattravel_value='NWI'"); // Norwich
        $this->execute("INSERT INTO dict_airport SET id=47, name='Teeside', bestattravel_value='MME'"); // Teeside

        $this->alterColumn('user', 'user_title', "ENUM('Mr', 'Mrs', 'Miss', 'Ms', 'Dr') NOT NULL");
        $this->alterColumn('travel_quote', 'user_title', "ENUM('Mr', 'Mrs', 'Miss', 'Ms', 'Dr') NOT NULL");

        $this->execute('DELETE FROM travel_quote');
        $this->addColumn('user', 'best_time2contact', 'VARCHAR(50)');
        $this->addColumn('travel_quote', 'best_time2contact', 'VARCHAR(50) NOT NULL');
    }

    public function safeDown()
    {
        echo "m190711_101936_add_bestatravel cannot be reverted.\n";

        return false;
    }
}
