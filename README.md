# BookApp

Instalace aplikace je popsána níže. Postupujte dle typu vašeho web-serveru.

Databáze je uložena v souboru `/db/books.db` (SQLite3)

## Apache:

- Doménu směrovat do adresáře `/public`
- Povolit mod Rewrite
- Povolit a nastavit mod PHP
- Povolit použití souboru `.htaccess` pro Host/VirtualHost
- Spustit/restartovat Apache

## nginx

- Nastavit PHP server
- Doménu směrovat do adresáře `/public`
- Pokud se nejedná o existující soubor či adresář, tak veškeré dotazy směrovat na skript `index.php`
- Spustit/restartovat nginx

## PHP

- povolit modul `mbstring`
- povolit modul `sqlite3`
- povolit modul `pdo` a `pdo_sqlite3`
- verze **7.2** či vyšší
