# WordPressi Teateriba Plugin

## Kirjeldus
See on kooliprojekti raames loodud WordPressi pistikprogramm, mis võimaldab administraatoril kuvada veebilehe ülaservas kohandatavat teateriba.

## Funktsionaalsus
* **Admin-menüü:** WordPressi hallatavasse paneeli lisandub menüüpunkt "Armini Teateriba".
* **Kohandatav tekst:** Administraator saab sisestada teate teksti.
* **Värvivalik:** Võimalus valida nii teateriba taustavärvi kui ka teksti värvi (lähtutud Itteni värviringi kontrastireeglitest).
* **Dünaamiline kuvamine:** Teadet kuvatakse automaatselt kõigil lehtedel kohe pärast `<body>` märgendit.
* **Sulgemisnupp:** Lisatud on JavaScript-põhine "X" nupp teate peitmiseks.

## Paigaldamine
1. Laadi fail `armin-teateriba.php` alla.
2. Liiguta see oma WordPressi kausta: `wp-content/plugins/`.
3. Aktiveeri plugin WordPressi administreerimispaneelist.

## Tehniline lahendus
Plugin kasutab WordPressi standardseid hooke:
* `admin_menu` – seadete lehe loomiseks.
* `wp_body_open` – teate kuvamiseks lehe esiosas.
* `update_option` ja `get_option` – seadete salvestamiseks andmebaasi.
