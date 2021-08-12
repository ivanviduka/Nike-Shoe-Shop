# Nike-Shoe-Shop

Heroku link: https://nike-shoe-shop.herokuapp.com/

Projekt prikazuje web-shop za Nike patike. Na početnoj stranici prikazani su bitni sportski događaji na kojima je nošena Nike oprema te patike koje je moguće naručiti. Odabir veličine patika napravljen je pomoću radio buttona. U bazi podataka nije implementirano praćenje preostale količine i broja patika (moguće je neograničeno naručivati). Također, header stranice je drugačiji ovisno o tome je li korisnik ulogiran ili ne. Ukoliko nije, u desnom kutu može vidjeti ikonicu za shop-cart koja otvara popis svih odabranih patika i opciju za kupovinu, te link koji ga odvodi na stranicu za logiranje. Ukoliko je korisnik već prijavljen, prikazan mu je shop-cart, link za odjavu, zajedno s njegovim e-mailom te link za pregled narudžbi koje je dosada kreirao.

Na stranici za prijavu, korisnik mora unijeti ispravan e-mail i lozinku, a ukoliko nema račun, može se registrirati na idućoj stranici. E-mail račun koji se koristi pri registraciji mora biti jedinstven (u bazi podataka ima atribut unique).

Patike koje su dodane u košaricu mogu se maknuti klikom na gumb REMOVE. Nakon klika na BUY NOW gumb, korisnik prelazi na stranici gdje vidi uvećan prikaz shop-carta te ukupnu cijenu. Za kreiranje narudžbe, mora unijeti informacije o gradu, adresi i broju mobitela. Ukoliko korisnik nije prijavljen, tada mora unijeti i e-mail račun. Ako je narudžba uspješno kreirana, korisnik se vraća na početnu stranicu, gdje vidi poruku o uspješnoj kreaciji narudžbe. Ukoliko je napravljena greška pri unosu podataka, korisnik ostaje na istoj stranici i mora unijeti ispravne vrijednosti.

Pri spremanju narudžbe u bazu podataka, datum dostave se kreira nasumično, u rasponu od 2 do 4 tjedna.

Kada prijavljeni korisnik odabere link za svoje narudžbe, prikazuje mu se popis svih narudžbi iz baze podataka koje imaju njegov e-mail. Narudžbe kojima je datum isporuke prošao, briše su iz baze podataka i ne prikazuju na popisu. 
