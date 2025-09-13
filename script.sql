create table slopes
(
    id          serial
        primary key,
    name        varchar(100)     not null,
    location    varchar(100),
    latitude    double precision not null,
    longitude   double precision not null,
    level_green boolean default false,
    level_blue  boolean default false,
    level_red   boolean default false,
    level_black boolean default false,
    status      boolean default true
);

alter table slopes
    owner to docker;

create table articles
(
    id         serial
        primary key,
    title      varchar(255) not null,
    content    text         not null,
    author     varchar(100),
    image_url  varchar(255),
    created_at timestamp default CURRENT_TIMESTAMP
);

alter table articles
    owner to docker;

create table users
(
    id            serial
        primary key,
    username      varchar(50)  not null
        unique,
    email         varchar(100) not null
        unique,
    password_hash text         not null,
    role          varchar(20) default 'user'::character varying,
    created_at    timestamp   default CURRENT_TIMESTAMP
);

alter table users
    owner to docker;

create table ranking
(
    id            serial
        primary key,
    user_id       integer not null
        references users
            on delete cascade,
    points        integer        default 0,
    distance_km   numeric(10, 2) default 0,
    max_speed_kmh numeric(10, 2) default 0,
    created_at    timestamp      default CURRENT_TIMESTAMP
);

alter table ranking
    owner to docker;

create view ranking_view(user_id, username, points, distance_km, max_speed_kmh) as
SELECT u.id AS user_id,
       u.username,
       r.points,
       r.distance_km,
       r.max_speed_kmh
FROM users u
         JOIN ranking r ON u.id = r.user_id
ORDER BY r.points DESC;

alter table ranking_view
    owner to docker;

INSERT INTO public.users (id, username, email, password_hash, role, created_at) VALUES (11, 'admin', 'admin@admin.pl', '$2y$10$x48WJAEsrILTTVqlCitpoeUtuWIit82DhPoCvcIjNzIpYtyV8Pb7W', 'admin', '2025-09-11 07:48:09.627240');

INSERT INTO public.users (id, username, email, password_hash, role, created_at) VALUES (24, 'user', 'user@user.pl', '$2y$10$hQBAgkSzlDi/tpzMGXOKROVZz1tRqIi4knnwem8TOROXvRUN87w16', 'user', '2025-09-13 06:08:09.546845');

INSERT INTO public.articles (id, title, content, author, image_url, created_at) VALUES (1, 'Nowoczesne technologie w narciarstwie', e'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ut eros in augue malesuada egestas.
 Praesent sit amet felis at arcu luctus posuere. Quisque pretium, magna non tempus luctus, nunc est posuere turpis,
 et scelerisque ipsum magna at ligula. Donec vulputate eros sed neque fermentum commodo.

 Morbi tristique convallis nisi, non ultrices tortor sodales ut. Sed vel leo id neque scelerisque ultricies.
 Curabitur sit amet semper justo. Fusce eget ante augue. Sed nec nulla nec lectus cursus ultrices vel ac elit.
 Aliquam erat volutpat. Sed viverra euismod felis, eu malesuada sem lacinia id. Suspendisse potenti.

 Integer tincidunt leo ut sapien gravida, nec fermentum eros gravida. Morbi accumsan, felis nec ultrices egestas,
 nibh justo vehicula ligula, nec lacinia ipsum risus ac leo. Donec nec purus faucibus, luctus felis in, ullamcorper leo.', 'Karol Mazur', 'https://picsum.photos/400/200?random=10', '2025-09-07 18:43:23.258228');
INSERT INTO public.articles (id, title, content, author, image_url, created_at) VALUES (2, 'Jak wybrać odpowiednie buty narciarskie?', e'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum a felis ut magna finibus pretium.
 Proin volutpat feugiat tortor non ullamcorper. Nulla facilisi. Sed at sapien et sapien tincidunt suscipit eget non nulla.
 Donec ac risus eget est efficitur fringilla sit amet sed metus.

 Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
 Cras non erat vel sapien faucibus bibendum. Donec eget quam vel dui porttitor consequat.
 Duis feugiat lacus nec arcu dictum, nec interdum magna viverra. Nulla facilisi.

 Integer maximus bibendum nisi, ut volutpat lorem. Fusce tempor leo id lectus imperdiet condimentum.
 Suspendisse potenti. Ut fermentum, mi ut hendrerit blandit, lectus purus finibus nunc, eget pharetra magna urna id ex.', 'Agnieszka Krawczyk', 'https://picsum.photos/400/200?random=11', '2025-09-07 18:43:23.258228');
INSERT INTO public.articles (id, title, content, author, image_url, created_at) VALUES (3, 'Historia narciarstwa w Europie', e'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed malesuada sem vitae orci posuere, a dignissim erat tristique.
 Ut facilisis ullamcorper risus. Phasellus tempor felis nec sapien volutpat, sed sagittis ligula faucibus.
 Vivamus sit amet est vel mauris fermentum euismod.

 Aliquam blandit interdum malesuada. Cras nec felis id sem gravida luctus non nec tortor.
 Nulla rhoncus imperdiet ligula, id tincidunt ligula fringilla nec. Mauris quis mauris vel nisi ultrices varius.
 Donec vulputate varius massa vel tristique.

 Aenean sed elit sit amet eros convallis vulputate. In at lacus sed justo porttitor malesuada.
 Quisque ac risus non mi egestas commodo. Vivamus venenatis risus non dui egestas viverra.
 Sed non risus ac arcu accumsan ultrices sed non leo.', 'Michał Lewandowski', 'https://picsum.photos/400/200?random=12', '2025-09-07 18:43:23.258228');
INSERT INTO public.articles (id, title, content, author, image_url, created_at) VALUES (4, 'Najlepsze ośrodki narciarskie w Alpach', e'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque egestas, justo in luctus imperdiet,
 nunc nulla tristique lacus, vel imperdiet velit quam et orci. Integer a mattis ipsum. Suspendisse nec laoreet mauris.
 Sed id lorem non elit volutpat scelerisque vitae non erat. Aliquam sagittis porttitor felis nec sagittis.
 Curabitur pulvinar dui id erat interdum, vitae vestibulum sapien hendrerit.

 Morbi dignissim odio nec erat elementum iaculis. Proin nec metus ac lorem finibus imperdiet.
 Nullam dignissim nisl erat, sit amet cursus eros luctus non. Sed et augue nec risus vehicula fringilla sed sed dui.
 Fusce vel tincidunt erat. Donec viverra nunc id magna tempor, nec aliquam lectus imperdiet.', 'Anna Kowalska', 'https://picsum.photos/800/400?random=21', '2025-09-07 19:01:04.698336');
INSERT INTO public.articles (id, title, content, author, image_url, created_at) VALUES (5, '10 wskazówek dla początkujących narciarzy', e'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque pretium felis in ligula dictum, at malesuada sem bibendum.
 Nam fermentum, tortor nec tempus tincidunt, magna libero suscipit erat, nec tristique nibh erat in orci.
 Mauris eget sagittis lorem. Integer bibendum, augue et eleifend pretium, felis felis porta purus, vitae fermentum orci nulla sed arcu.

 Sed suscipit, ex eget posuere scelerisque, lorem neque malesuada est, at condimentum eros est nec nulla.
 Vestibulum ac libero sit amet libero fringilla mattis. Vivamus id sollicitudin lorem, ac ultrices elit.', 'Piotr Nowak', 'https://picsum.photos/800/400?random=22', '2025-09-07 19:01:04.698336');
INSERT INTO public.articles (id, title, content, author, image_url, created_at) VALUES (6, 'Jak przygotować sprzęt na sezon zimowy?', e'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse bibendum nulla sit amet magna volutpat,
 sed sollicitudin odio malesuada. Integer nec felis purus. In efficitur suscipit dignissim.
 Suspendisse tristique dui vitae dignissim iaculis. Aliquam erat volutpat.

 Vivamus vehicula turpis in velit porta maximus. Cras ut vestibulum libero.
 Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
 Mauris sit amet nisi sit amet quam cursus tempor vel a ligula. Etiam maximus urna sit amet felis sodales iaculis.', 'Katarzyna Wiśniewska', 'https://picsum.photos/800/400?random=23', '2025-09-07 19:01:04.698336');
INSERT INTO public.articles (id, title, content, author, image_url, created_at) VALUES (7, 'Snowboard czy narty – co wybrać?', e'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sodales eros eget lacus facilisis vehicula.
 Proin ac ligula mi. Duis convallis diam nec tortor porttitor, nec sodales ex aliquet.
 Donec imperdiet, nunc sit amet iaculis ultrices, magna tortor hendrerit leo, eget condimentum magna risus non odio.

 Nulla sagittis tincidunt orci. Integer sodales sem vel ex luctus malesuada.
 Phasellus egestas lectus eget nisi varius, vitae feugiat purus aliquam. Suspendisse ac cursus sapien, eget bibendum ex.
 Cras nec lorem eu libero aliquam condimentum.', 'Tomasz Zieliński', 'https://picsum.photos/800/400?random=24', '2025-09-07 19:01:04.698336');
INSERT INTO public.articles (id, title, content, author, image_url, created_at) VALUES (8, 'Najciekawsze trasy narciarskie w Polsce', e'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin interdum, mauris nec blandit malesuada,
 lacus nisi feugiat purus, id elementum leo turpis at nisl. Mauris dignissim ligula sit amet dictum volutpat.
 Integer egestas ex ac felis dictum, eget vulputate mauris iaculis. Nullam et felis eu mauris viverra cursus.

 Sed a nisl accumsan, vestibulum justo non, blandit metus. Suspendisse in dui eget lacus rhoncus sodales nec in nunc.
 Pellentesque vel augue eget elit fermentum tincidunt. Vivamus lacinia felis sit amet mi fermentum, vel laoreet neque mattis.', 'Ewa Maj', 'https://picsum.photos/800/400?random=25', '2025-09-07 19:01:04.698336');
INSERT INTO public.articles (id, title, content, author, image_url, created_at) VALUES (9, 'Bezpieczeństwo na stoku – o czym pamiętać?', e'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer pulvinar libero at tellus luctus,
 vitae gravida leo dapibus. Aliquam vitae nulla sed sapien pretium viverra.
 Vestibulum vitae ligula sed nulla vulputate hendrerit nec nec libero.
 Mauris dapibus, nibh vel scelerisque blandit, lacus justo finibus nulla, sit amet condimentum erat lacus sed odio.

 Donec laoreet neque non risus malesuada, nec sollicitudin lacus ultrices.
 Nullam malesuada faucibus nisi nec dictum. Suspendisse sit amet sem ac sem rutrum posuere.
 In euismod ex vel dui suscipit malesuada.', 'Jan Malinowski', 'https://picsum.photos/800/400?random=26', '2025-09-07 19:02:19.583462');
INSERT INTO public.articles (id, title, content, author, image_url, created_at) VALUES (10, 'Jak działa ratrak i dlaczego jest tak ważny?', e'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque quis vehicula purus.
 Quisque convallis, risus eget convallis ultricies, enim justo congue purus, vel luctus turpis sem at nisl.
 Integer tristique egestas dolor, at euismod nisi fermentum vel. Nam convallis gravida erat,
 id gravida turpis dictum et. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae.

 Aliquam ut mauris vitae sem hendrerit commodo.
 Donec in turpis vel odio dictum dapibus eget id lorem.
 Suspendisse cursus ante eget felis suscipit, nec eleifend eros fermentum.', 'Marek Jankowski', 'https://picsum.photos/800/400?random=27', '2025-09-07 19:02:19.583462');
INSERT INTO public.articles (id, title, content, author, image_url, created_at) VALUES (11, 'Najczęstsze kontuzje narciarskie i jak ich unikać', e'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin bibendum,
 elit vel varius ultricies, arcu justo vulputate urna, at hendrerit est turpis in orci.
 Suspendisse potenti. Sed vel sapien quis orci malesuada efficitur.
 Donec facilisis diam nec magna scelerisque lacinia. Mauris vel augue sit amet massa imperdiet finibus.

 Cras vehicula lectus sed viverra faucibus.
 Integer ullamcorper tellus non felis posuere, ut rhoncus mi fringilla.
 Praesent congue luctus eros, vitae lacinia lacus cursus a.', 'Joanna Pawlak', 'https://picsum.photos/800/400?random=28', '2025-09-07 19:02:19.583462');
INSERT INTO public.articles (id, title, content, author, image_url, created_at) VALUES (12, 'Historia snowboardu – od pasji do sportu olimpijskiego', e'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam ac posuere eros.
 Duis eget arcu sem. Sed vel tellus feugiat, eleifend leo in, consequat purus.
 Proin suscipit lorem nec rhoncus porttitor. Integer fermentum ultrices sapien sed interdum.

 Sed nec libero nec nisl mattis rhoncus.
 Pellentesque rutrum diam at magna vehicula, sit amet pulvinar massa ornare.
 Nullam at nisl ut nulla hendrerit tincidunt vitae at arcu.', 'Andrzej Kamiński', 'https://picsum.photos/800/400?random=29', '2025-09-07 19:02:19.583462');
INSERT INTO public.articles (id, title, content, author, image_url, created_at) VALUES (13, 'Dlaczego warto wybrać instruktora narciarskiego?', e'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ut ipsum a lorem vehicula luctus.
 Duis varius magna nec semper aliquam. Etiam iaculis, sapien sit amet laoreet cursus,
 magna nisl malesuada purus, vel pulvinar ligula augue vel est.

 Integer ultricies eros mi, vel cursus justo dictum sed.
 Suspendisse potenti. Fusce tempor luctus massa, ac mattis justo sagittis ac.
 Nunc varius felis nec dui accumsan, sed sagittis est posuere.', 'Paweł Dąbrowski', 'https://picsum.photos/800/400?random=30', '2025-09-07 19:02:19.583462');


INSERT INTO public.ranking (id, user_id, points, distance_km, max_speed_kmh, created_at) VALUES (6, 11, 600, 101.00, 510.00, '2025-09-13 03:11:14.648811');


INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (5, 'Kasprowy Wierch', 'Zakopane, Polska', 49.241, 19.981, false, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (6, 'Jaworzyna Krynicka', 'Krynica-Zdrój, Polska', 49.433, 20.957, true, true, true, false, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (7, 'Białka Tatrzańska', 'Białka, Polska', 49.384, 20.105, true, true, false, false, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (8, 'Szczyrk Mountain Resort', 'Szczyrk, Polska', 49.718, 19.033, true, true, true, true, false);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (9, 'Zakopane Nosal', 'Zakopane, Polska', 49.277, 19.981, true, false, false, false, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (10, 'Pilsko', 'Korbelowa, Polska', 49.567, 19.327, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (11, 'Chamonix', 'Francja', 45.923, 6.869, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (12, 'Val Thorens', 'Francja', 45.297, 6.58, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (13, 'Courchevel', 'Francja', 45.415, 6.634, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (14, 'Les Deux Alpes', 'Francja', 45.011, 6.123, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (15, 'Zermatt', 'Szwajcaria', 46.02, 7.749, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (16, 'St. Moritz', 'Szwajcaria', 46.49, 9.835, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (17, 'Kitzbühel', 'Austria', 47.444, 12.392, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (18, 'Ischgl', 'Austria', 47.012, 10.29, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (19, 'Sölden', 'Austria', 46.97, 11.01, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (20, 'Aspen Snowmass', 'Kolorado, USA', 39.208, -106.949, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (21, 'Vail', 'Kolorado, USA', 39.639, -106.374, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (22, 'Whistler Blackcomb', 'Kanada', 50.115, -122.948, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (23, 'Cortina d’Ampezzo', 'Włochy', 46.54, 12.135, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (24, 'Livigno', 'Włochy', 46.538, 10.141, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (25, 'Alta Ski Area', 'Utah, USA', 40.588, -111.638, false, false, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (26, 'Park City Mountain', 'Utah, USA', 40.651, -111.509, true, true, true, false, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (27, 'Breckenridge', 'Kolorado, USA', 39.481, -106.038, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (28, 'Keystone Resort', 'Kolorado, USA', 39.606, -105.943, true, true, true, false, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (29, 'Telluride', 'Kolorado, USA', 37.937, -107.812, false, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (30, 'Big Sky Resort', 'Montana, USA', 45.284, -111.401, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (31, 'Heavenly', 'Kalifornia/Nevada, USA', 38.935, -119.939, true, true, true, false, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (32, 'Mammoth Mountain', 'Kalifornia, USA', 37.63, -119.032, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (33, 'Sun Valley', 'Idaho, USA', 43.695, -114.353, true, true, true, false, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (34, 'Jackson Hole', 'Wyoming, USA', 43.587, -110.827, false, false, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (35, 'Andermatt-Sedrun', 'Szwajcaria', 46.633, 8.6, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (36, 'Laax', 'Szwajcaria', 46.823, 9.265, true, true, true, false, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (37, 'Verbier', 'Szwajcaria', 46.098, 7.227, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (38, 'Grindelwald-Wengen', 'Szwajcaria', 46.624, 8.042, true, true, true, false, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (39, 'Davos Klosters', 'Szwajcaria', 46.8, 9.833, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (40, 'Obergurgl-Hochgurgl', 'Austria', 46.87, 11.03, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (41, 'Serfaus-Fiss-Ladis', 'Austria', 47.037, 10.61, true, true, true, false, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (42, 'Schladming-Dachstein', 'Austria', 47.393, 13.691, true, true, true, false, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (43, 'Bad Gastein', 'Austria', 47.118, 13.134, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (44, 'Bansko', 'Bułgaria', 41.825, 23.485, true, true, true, false, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (45, 'Borovets', 'Bułgaria', 42.265, 23.603, true, true, true, false, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (46, 'Kopaonik', 'Serbia', 43.285, 20.8, true, true, true, false, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (47, 'Poiana Brașov', 'Rumunia', 45.597, 25.552, true, true, true, false, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (48, 'Niseko United', 'Japonia', 42.854, 140.684, true, true, true, false, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (49, 'Hakuba Valley', 'Japonia', 36.7, 137.833, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (50, 'Shiga Kogen', 'Japonia', 36.73, 138.5, true, true, true, false, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (51, 'Thredbo', 'Australia', -36.503, 148.302, true, true, true, false, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (52, 'Perisher', 'Australia', -36.405, 148.411, true, true, true, false, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (53, 'Portillo', 'Chile', -32.837, -70.123, false, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (54, 'Valle Nevado', 'Chile', -33.35, -70.25, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (55, 'Cerro Catedral', 'Argentyna', -41.167, -71.5, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (56, 'Las Leñas', 'Argentyna', -35.155, -70.07, false, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (57, 'Gulmarg', 'Indie', 34.048, 74.38, false, false, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (58, 'Yabuli', 'Chiny', 44.7, 128.45, true, true, true, false, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (59, 'Almaty Shymbulak', 'Kazachstan', 43.112, 77.085, true, true, true, true, true);
INSERT INTO public.slopes (id, name, location, latitude, longitude, level_green, level_blue, level_red, level_black, status) VALUES (60, 'Rosa Khutor', 'Rosja', 43.671, 40.297, true, true, true, true, true);

