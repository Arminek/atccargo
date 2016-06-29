Projekt strony ATC-Cargo
=======

### Rejestracja
Tylko Szef może wysłać "zaproszenie" dla pracownika aby ten mógł się zarejestrować na stronie. Aby zaprosić nowego pracownika do rejestracji na stronie należy wykonać następujące kroki

1. W zakładce `Dodaj Pracownika` wypełniamy pola:
  * Stanowisko
  * Email
2. Pracownik odbiera na swoim emailu specjalny klucz rejestracyjny.
3. Pracownik weryfikuje swój klucz pod adresem `http://atc-cargo.com/register/verifictaion` aby system pomyślnie zweryfikował klucz musimy też wpisać email na który otrzymaliśmy klucz.
  * Gdy kod jest poprawny użytkownik może zacząć rejestrację konta pod adresem `htttp://atc-cargo.com/register`
  * Gdy kod jest nie poprawny, system wyświetli komunikat z błędem.

### System rang
System rang jest stworzony po to aby wygodnie zarządzać transportami i pracownikami.
* Szef
* V-CE Szef
* Dyspozytor
* Kierowca
* Okres testowy

### Uprawnienia
Niektóre rangi mają możliwość przeglądania transportów, przeglądania pracowników lub dodawania pracowników.

| Zakładka                | Ranga                         |
| ----------------------- | ----------------------------- |
| Przeglądaj transporty   | Szef, V-CE Szef, Dyspozytor   |
| Przeglądaj pracowników  | Szef                          |
| Dodaj pracownika        | Szef                          |
