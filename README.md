# Eevee-osuserver
osu! 2007 Private Server, runs on just about anything that runs PHP

To run Import eevee.sql and change mysql login details in config.php

# Yet to be Added:

* Ingame Ranking Display Beatmap (Look Below on how this will work) 
* Admin Panel //EXPECTEED AT PATCH 2.2
* Beatmap Ranking System //EXPECTEED AT PATCH 2.2
* Staff Managment //EXPECTEED AT PATCH 2.2
* Privledges //EXPECTEED AT PATCH 2.2

# Ingame Ranking Display Beatmap

My Proposal to this would be since on getting Ranking Panel Information,
you get the Beatmap MD5 Hash, the Server could check if that Map corresponds
to something the Ranking Panel should show, for Example we will Probably have
a Beatmap that will instead of outputting normal Ranking Scores,
return Usernames like "Score" or "Rank" or anything that we can record.

Example Score Ranking:

[S] Ranked Score

Score: 10000000 Combo: 0

[A] Global Leaderboard Rank

Score: 933 Combo: 0

[B] Total Score

Score: 15000000 Combo: 0

[C] EXPERIMENTAL: Performance

Score: 892 Combo: 0

[D] EXPERIMENTAL: Performance Ranking

Score: 16 Combo: 0
