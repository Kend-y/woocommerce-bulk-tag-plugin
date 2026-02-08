# Bulk Tag Updater pentru WooCommerce

Plugin simplu care te ajută să actualizezi rapid tag-urile promoționale la produsele din WooCommerce. Salvează timp când trebuie să modifici tag-uri la zeci sau sute de produse deodată.

## Ce face?

Practic, adaugă un câmp personalizat "Promo Tag" la toate produsele tale WooCommerce și îți oferă o interfață centralizată unde poți vedea și modifica toate tag-urile dintr-un singur loc. Am făcut plugin-ul pentru că era enervant să intri în fiecare produs separat doar ca să schimbi un tag.

## Funcționalități principale

### 1. Câmp personalizat universal
- Adaugă câmpul "Tag" la **TOATE tipurile** de produse WooCommerce:
- Câmpul apare în tabul **Inventory** din Product Data
- Se salvează automat când actualizezi produsul

### 2. Pagină centralizată de management
- Interfață dedicată sub **WooCommerce → Product Tag**
- Vezi toate produsele într-un tabel clar și organizat
- Afișează informații importante: imagine, nume, stoc, preț, tag curent
- Paginare automată (10 produse per pagină) pentru performanță optimă

### 3. Trei moduri de actualizare

**a) Actualizare individuală**
- Fiecare produs are propriul câmp de editare în tabel
- Modifici tag-ul direct din listă, fără să deschizi produsul
- Buton "Save" individual pentru fiecare produs
- Perfect pentru ajustări rapide la 1-2 produse

**b) Actualizare selectată (bulk update)**
- Checkbox-uri pentru fiecare produs
- Selectezi exact produsele care te interesează
- Un singur câmp de input pentru tag-ul dorit
- Buton "Actualizează selectate" care aplică tag-ul la toate produsele bifate
- Bonus: Checkbox "Select All" în header pentru a bifa toate produsele dintr-o dată

**c) Actualizare totală**
- Actualizează TOATE produsele din lista curentă cu un singur click
- Respectă filtrele active
- Câmp de input separat pentru claritate
- Buton "Actualizează toate" distinct
- Ideal pentru campanii promoționale sau resetări în masă

### 4. Căutare
- Caută produse după **nume** (doar în titlu, nu în descriere)
- Căutare rapidă și precisă
- Rezultatele apar instant
- Perfect când știi exact ce produs cauți

### 5. Filtrare pe categorii
- Dropdown cu toate categoriile tale WooCommerce
- Filtrează lista pentru a vedea doar produsele dintr-o categorie
- Combină cu căutarea pentru rezultate și mai precise

### 6. Combinații puternice 

**Căutare + Update toate**
Cauți "laptop", apoi dai update la toate laptopurile găsite. Super rapid pentru produse similare.

**Categorie + Update toate**
Filtrezi "Sale Items", scrii tag "50% OFF" și toate produsele din categoria respectivă primesc tag-ul. Perfect pentru promoții pe categorii întregi.

**Categorie + Căutare + Selectare**
Filtrezi categoria, cauți un cuvânt specific, bifezi doar câteva produse și actualizezi. Maximum control.

**Paginare + Selectare manuală**
Navighezi prin pagini, bifezi produse random din diferite categorii, apoi actualizezi tot ce-ai bifat. Funcționează pentru scenarii complexe.


### 7. Resetare rapidă
- Buton "Reseteaza" pentru a șterge toate filtrele
- Te întoarce instant la lista completă de produse
- Util când vrei să începi o nouă căutare de la zero  

## Ce îți trebuie

- WordPress 5.0+ 
- WooCommerce 3.0+
- PHP 7.0 sau ceva mai nou

## Instalare

E destul de simplu:

1. Descarcă fișierul zip
2. Du-te în WordPress la Plugins → Add New
3. Apasă pe Upload Plugin
4. Alege fișierul zip
5. Instalează și activează

Gata! După ce activezi plugin-ul, o să găsești în meniul WooCommerce o opțiune nouă **Product Tag**.

## Cum îl folosești

### Accesare
Mergi la **WooCommerce → Product Tag** și o să vezi pagina principală cu tabelul de produse.

### Interfața explicată

**Zona de sus:**
- Câmp de căutare (pentru numele produsului)
- Dropdown categorie (pentru filtrare)
- Butoane "Filtreaza" și "Reseteaza"

**Zona de actualizare bulk:**
- Două seturi de controale (unul pentru selectate, unul pentru toate)
- Separatorul "|" între ele pentru claritate vizuală

**Tabelul de produse:**
- Checkbox (pentru selectare)
- Imagine produs
- Nume + linkuri Edit și View
- Status stoc (colorat: verde=în stoc, roșu=indisponibil, gri=pe comandă)
- Preț
- Coloana "Actiune" cu câmp individual și buton Save

### Scenarii de utilizare

**Scenariu 1: Lansare produse noi**
1. Căutare: scrii "2024" (sau cum denumești produsele noi)
2. Bifezi toate produsele găsite (sau folosești checkbox din header)
3. Scrii "NOU" în câmpul pentru selectate
4. Apeși "Actualizează selectate"
5. Rezultat: Toate produsele noi au tag-ul "NOU"

**Scenariu 2: Promoție pe o categorie întreagă**
1. Filtrare: alegi categoria "Electrocasnice" din dropdown
2. Apeși "Filtreaza"
3. Scrii "REDUCERE 30%" în câmpul pentru toate
4. Apeși "Actualizează toate"
5. Rezultat: Toate produsele din Electrocasnice au tag-ul de reducere

**Scenariu 3: Actualizare rapidă pentru un produs**
1. Căutare: găsești produsul specific
2. În coloana "Actiune", scrii tag-ul direct în câmp
3. Apeși "Save" de lângă produs
4. Rezultat: Doar acel produs e actualizat, fără să-l deschizi

**Scenariu 4: Mix de produse din categorii diferite**
1. Nu folosești filtre (vezi toate produsele)
2. Navighezi prin pagini și bifezi manual produsele dorite
3. Scrii tag-ul pentru selectate
4. Actualizezi
5. Rezultat: Doar produsele bifate sunt modificate

**Scenariu 5: Resetare tag-uri după promoție**
1. Filtrare: categoria "Sale Items"
2. Scrii câmp gol
3. Actualizezi toate
4. Rezultat: Toate produsele din categoria respectivă au tag-ul șters/resetat

### Editare tag din pagina produsului

Ai două locații unde poți edita tag-ul:

**Opțiunea 1: Din plugin (recomandat pentru bulk)**
WooCommerce → Product Tag → tabel cu toate produsele

**Opțiunea 2: Din pagina produsului (pentru editări individuale)**
1. Products → All Products
2. Click pe produsul dorit
3. În Product Data, deschide tabul **Inventory**
4. Găsești câmpul "Promo Tag" după SKU și Stock
5. Completezi și salvezi produsul

## Exemple practice

**Exemplu 1: Black Friday**
Vrei să marchezi 50 de produse pentru Black Friday:
- Filtrezi categoria "Deals"
- Scrii "BLACK FRIDAY -70%" în câmpul pentru toate
- Boom, toate produsele de deal au tag-ul

**Exemplu 2: Produse epuizate**
Vrei să marchezi ce e "Coming Soon":
- Filtrezi și găsești produsele fără stoc
- Selectezi manual cele care revin în stoc
- Tag: "Disponibil în curând"

**Exemplu 3: Colecție nouă**  
Lansezi o colecție "Summer 2024":
- Cauți "summer" în căutare
- Bifezi toate produsele relevante
- Tag: "Summer Collection 2024"

## Exemple

**Exemplu 1:** Vrei să marchezi produse noi  
Bifezi produsele, scrii "NOU", actualizezi. Done.

**Exemplu 2:** Produse la reducere  
FilDetalii tehnice (dacă te interesează)

Plugin-ul salvează tag-urile ca meta data (`_promo_tag`) pentru fiecare produs. Am folosit API-ul WordPress pentru toate operațiunile, deci e safe și compatible.

Structura e simplă:
- `wc_bulk_tag.php` - fișierul principal
- `assets/css/admin.css` - stilurile pentru pagina admin
- `README.md` - fișierul curent

Securitate:
- Am folosit nonce-uri pentru toate formularele
- Inputurile sunt sanitizate 
- Doar utilizatorii cu permisiunea `manage_woocommerce` pot accesa

## Probleme comune

**Plugin-ul nu apare în meniu**  
Verifică dacă WooCommerce e instalat și activat. Și dacă ai permisiuni de admin.

**Tag-urile nu se salvează**  
Încearcă să refreshuiești pagina. Sau verifică dacă ești încă logat.

**Eroare "Te rog selectează cel puțin un produs"**  
Înseamnă că ai apăsat "Actualizează selectate" fără să bifezi produse. Bifează ceva întâi.
Dolghieru Maxim

## Info

Versiune: 1.0.0  
Autor: Dolghieru Maxim

