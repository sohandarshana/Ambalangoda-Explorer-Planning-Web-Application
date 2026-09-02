CREATE DATABASE IF NOT EXISTS ambalangoda_trip;
USE ambalangoda_trip;

CREATE TABLE IF NOT EXISTS categories (
    id VARCHAR(50) PRIMARY KEY,
    label VARCHAR(100) NOT NULL,
    blurb TEXT NOT NULL,
    pill VARCHAR(100) NOT NULL,
    chip VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS places (
    id VARCHAR(100) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category_id VARCHAR(50) NOT NULL,
    distanceKm DECIMAL(5,2) NOT NULL,
    summary TEXT NOT NULL,
    description TEXT NOT NULL,
    imageUrl VARCHAR(255) NOT NULL,
    openingHours VARCHAR(100) NOT NULL,
    entryFee VARCHAR(100) NOT NULL,
    contact VARCHAR(50) NOT NULL,
    visitDurationMin INT NOT NULL,
    lat DECIMAL(9,6) NOT NULL,
    lng DECIMAL(9,6) NOT NULL,
    bestTime VARCHAR(100) NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE IF NOT EXISTS place_highlights (
    id INT AUTO_INCREMENT PRIMARY KEY,
    place_id VARCHAR(100) NOT NULL,
    highlight VARCHAR(255) NOT NULL,
    FOREIGN KEY (place_id) REFERENCES places(id)
);

-- Insert Categories
INSERT INTO categories (id, label, blurb, pill, chip) VALUES
('Cultural Attraction', 'Culture', 'Masks, puppets and the crafts Ambalangoda is known for', 'bg-ochre-100 text-ochre-600', 'bg-ochre-600 text-sand-50 border-ochre-600'),
('Religious Site', 'Temples & shrines', 'Working temples and harbour-side devalayas', 'bg-ocean-100 text-ocean-700', 'bg-ocean-700 text-sand-50 border-ocean-700'),
('Heritage & Nature', 'Heritage & nature', 'Traditional industries still worked by hand', 'bg-moss-100 text-moss-600', 'bg-moss-600 text-sand-50 border-moss-600'),
('Wildlife Attraction', 'Wildlife', 'Turtle conservation along the Kosgoda coast', 'bg-moss-100 text-moss-600', 'bg-moss-600 text-sand-50 border-moss-600'),
('Beach', 'Beaches', 'The town strand and the coves few people find', 'bg-ocean-100 text-ocean-700', 'bg-ocean-600 text-sand-50 border-ocean-600'),
('Cafe', 'Cafes', 'Coffee and short eats between stops', 'bg-coral-100 text-coral-600', 'bg-coral-600 text-sand-50 border-coral-600'),
('Restaurant', 'Restaurants', 'Rice and curry, and the harbour catch', 'bg-coral-100 text-coral-600', 'bg-coral-600 text-sand-50 border-coral-600');

-- Insert Places
INSERT INTO places (id, name, category_id, distanceKm, summary, description, imageUrl, openingHours, entryFee, contact, visitDurationMin, lat, lng, bestTime) VALUES
('ariyapala-mask-museum', 'Ariyapala Mask Museum', 'Cultural Attraction', 1.7, 'Sri Lanka''s best-known collection of carved ritual masks, still made by the family next door.', 'The Ariyapala Mask Museum holds the country''s reference collection of Kolam, Sanni and Raksha masks, with the workshop beside it where carvers still shape kaduru wood by hand. Displays explain how each mask belongs to a specific healing ritual or village drama, and short demonstrations of the devil-dance tradition run through the day.', '/2e6c58e3-a67a-40cc-b4fa-e17a0f6e5d1c.jpg', 'Daily 8:30 AM – 5:30 PM', 'LKR 300 (locals) · LKR 800 (foreign visitors)', '+94 91 225 8373', 60, 6.2306, 80.0555, 'Morning, before the coach groups arrive'),
('puppet-museum', 'Ambalangoda Puppet Museum', 'Cultural Attraction', 1.8, 'The last home of Sri Lankan string puppetry, kept alive by one family of puppeteers.', 'A small, quiet museum preserving the rukada natya string-puppet tradition that once toured the southern coast. Life-sized carved puppets in embroidered costume hang alongside old stage backdrops, and the caretaker will usually work a few of them for visitors and explain the stories they perform.', '/938e0210-31ff-40fe-b163-a40809386b41.jpg', 'Daily 9:00 AM – 5:00 PM', 'LKR 250 (locals) · LKR 600 (foreign visitors)', '+94 77 342 1180', 45, 6.2329, 80.0561, 'Any time — it is indoors and rarely crowded'),
('modara-devalaya', 'Ambalangoda Modara Devalaya', 'Religious Site', 2.9, 'A brightly painted harbour-side shrine where fishing crews leave offerings before going out.', 'Standing where the lagoon meets the sea, the Modara Devalaya is the working shrine of Ambalangoda''s fishing community. Its painted walls, oil lamps and daily offerings make it one of the most photogenic corners of the town, and the surrounding harbour is at its liveliest when the boats return.', '/44db75d4-dd63-43c2-b39c-dd3f07738f4d.jpg', 'Daily, dawn to dusk', 'Free — donations welcome', 'No published number', 30, 6.2455, 80.0505, 'Late afternoon, when the fleet comes in'),
('sunandarama-maha-viharaya', 'Sunandarama Maha Viharaya', 'Religious Site', 2.5, 'A historic Buddhist temple with a white stupa and a hall of low-country murals.', 'Sunandarama Maha Viharaya is the principal temple of Ambalangoda, known for its image house murals painted in the southern low-country style and a calm courtyard shaded by an old bodhi tree. Modest dress is expected; shoes and hats are removed at the entrance.', '/c24df3dc-a36d-473b-bd25-7de702394d7d.jpg', 'Daily 6:00 AM – 7:00 PM', 'Free — donations welcome', '+94 91 225 8104', 40, 6.2371, 80.0537, 'Early morning, cool and quiet'),
('meetiyagoda-moonstone-mine', 'Meetiyagoda Moonstone Mine', 'Heritage & Nature', 8, 'Hand-dug shafts where Sri Lanka''s blue moonstone is still washed and sorted by eye.', 'Meetiyagoda sits on the only significant blue moonstone deposit in the country. Miners descend narrow hand-dug shafts with a wooden windlass, and the gravel is washed and sorted in trays on the surface — a full, small-scale mining process you can watch in fifteen minutes, followed by the cutting and polishing sheds.', '/34770e6e-3322-49ca-b96d-a7507707e2de.jpg', 'Mon – Sat 8:00 AM – 5:00 PM', 'Free tour · gems sold separately', '+94 77 610 4429', 45, 6.1979, 80.0757, 'Weekday mornings, while crews are working'),
('turtle-hatchery', 'Ahungalla Turtle Hatchery', 'Wildlife Attraction', 5.1, 'A conservation hatchery raising green and olive ridley hatchlings for release at dusk.', 'Eggs collected from nearby beaches are incubated here and the hatchlings held briefly before release. Staff walk visitors through the tanks, explain the threats to each species, and on most evenings visitors can join the release of the day''s hatchlings into the surf.', '/94bb382f-125e-422c-9d47-ac474d7490cb.jpg', 'Daily 8:00 AM – 6:00 PM', 'LKR 500 (locals) · LKR 1,000 (foreign visitors)', '+94 91 226 4567', 50, 6.2919, 80.0322, 'Around 5:30 PM for the release'),
('ambalangoda-beach', 'Ambalangoda Beach & Fishing Harbour', 'Beach', 2, 'A wide town beach beside the harbour, with the day''s catch auctioned on the sand.', 'The main beach runs north from the fishing harbour, backed by palms and the old rest house. Mornings belong to the fish market and the boats; afternoons are for a long flat stretch of sand that stays largely free of crowds. Swimming is safest at the sheltered southern end near the breakwater.', '/e82c79b4-8b3c-4029-83c5-254bfbd49898.jpg', 'Open access', 'Free', '—', 60, 6.2372, 80.05, '6:30 – 8:00 AM for the market, or sunset'),
('oru-wella-beach', 'Oru Wella Beach', 'Beach', 3.8, 'A hidden rock-framed cove south of town that most visitors drive straight past.', 'Reached by a short lane through a palm grove, Oru Wella is a small cove sheltered by dark coastal rock. There are no vendors and no loungers — bring water and shade. Calmest between December and April, when the shallows behind the rocks are clear enough for snorkelling.', '/47e342c7-da8e-4626-a1cd-c6b79dff9851.jpg', 'Open access', 'Free', '—', 60, 6.2201, 80.0526, 'Late afternoon, December to April'),
('go-cup', 'Go Cup Ambalangoda', 'Cafe', 1.7, 'Open-shuttered coffee shop in town — the natural mid-morning stop between the museums.', 'A small independent cafe a few minutes from both museums, serving espresso, iced coffee, short eats and cake in a cool tiled room with the shutters open to the street. Reliable Wi-Fi and air-conditioned seating make it the easiest place in town to reset in the middle of a day trip.', '/d3db3ce5-395d-4e50-822f-242a647e5432.jpg', 'Daily 8:00 AM – 8:00 PM', 'LKR 500 – 1,500 per head', '+94 76 884 2310', 40, 6.2318, 80.0548, 'Mid-morning or after the beach'),
('amco-restaurant', 'Amco Restaurant', 'Restaurant', 1.9, 'Generous Sri Lankan rice and curry, plus fresh seafood off the Ambalangoda boats.', 'A long-running family restaurant on the main road serving a full rice-and-curry spread at lunch, with fish and prawns bought that morning at the harbour. Portions are large, the kitchen will adjust the chilli on request, and there is a shaded open-air section at the back.', '/ca221767-574f-45e0-9e69-db56fe23c168.jpg', 'Daily 10:30 AM – 10:00 PM', 'LKR 900 – 2,500 per head', '+94 91 225 5561', 60, 6.234, 80.056, '12:30 – 2:00 PM for the full lunch spread');

-- Insert Highlights
INSERT INTO place_highlights (place_id, highlight) VALUES
('ariyapala-mask-museum', 'Ritual mask collection'), ('ariyapala-mask-museum', 'Live carving workshop'), ('ariyapala-mask-museum', 'Mask library and shop'),
('puppet-museum', 'Rukada natya puppets'), ('puppet-museum', 'Short puppetry demonstration'), ('puppet-museum', 'Pairs well with the Mask Museum'),
('modara-devalaya', 'Harbour-side setting'), ('modara-devalaya', 'Evening lamp offerings'), ('modara-devalaya', 'Fishing boats returning'),
('sunandarama-maha-viharaya', 'Low-country temple murals'), ('sunandarama-maha-viharaya', 'White stupa and bodhi tree'), ('sunandarama-maha-viharaya', 'Poya-day ceremonies'),
('meetiyagoda-moonstone-mine', 'Working shaft and windlass'), ('meetiyagoda-moonstone-mine', 'Gem washing and sorting'), ('meetiyagoda-moonstone-mine', 'Cutting and polishing sheds'),
('turtle-hatchery', 'Hatchling tanks'), ('turtle-hatchery', 'Evening release on the beach'), ('turtle-hatchery', 'Small aquarium of reef fish'),
('ambalangoda-beach', 'Morning fish auction'), ('ambalangoda-beach', 'Painted outrigger boats'), ('ambalangoda-beach', 'Sheltered swimming near the breakwater'),
('oru-wella-beach', 'Quiet rock-framed cove'), ('oru-wella-beach', 'Clear shallows in season'), ('oru-wella-beach', 'Sunset viewpoint on the rocks'),
('go-cup', 'Espresso and iced coffee'), ('go-cup', 'Cakes and short eats'), ('go-cup', 'Wi-Fi and air conditioning'),
('amco-restaurant', 'Rice and curry spread'), ('amco-restaurant', 'Harbour-fresh seafood'), ('amco-restaurant', 'Shaded open-air seating');
