# 🎿 Ski Slopes – System do zarządzania stokami i rankingiem użytkowników

## 📌 Opis projektu
Projekt webowy w **PHP + JavaScript** z bazą danych **PostgreSQL**, którego celem jest:
- rejestracja i logowanie użytkowników,
- zarządzanie rankingiem aktywności (dystans, prędkość, punkty),
- dodawanie i przeglądanie artykułów,
- przeglądanie informacji o stokach narciarskich.

Aplikacja została przygotowana jako projekt zaliczeniowy.

---

## 🛠️ Technologie
- **PHP 8+** – backend (API, sesje, obsługa użytkowników)
- **PostgreSQL** – baza danych
- **JavaScript (ES6)** – frontend (fetch API, dynamiczne aktualizacje)
- **HTML5 + CSS3** – interfejs użytkownika
- **Docker + Docker Compose** – środowisko uruchomieniowe
- **PlantUML** – dokumentacja ERD

---

## 📂 Struktura katalogów
backend/
├── api/ # endpointy 
├── config/ # konfiguracja bazy
├── models/ # klasy domenowe 
├── repositories/ # repozytoria do obsługi tabel
└── ...
public/
├── scripts/ # frontend JS
├── styles/ # pliki CSS
└── views/ # widoki 


---

## 🗄️ Struktura bazy danych

### Tabele
- **users** – dane użytkowników (login, hasło, rola, data utworzenia)
- **ranking** – punkty, dystans, maksymalna prędkość
- **articles** – artykuły publikowane w systemie
- **slopes** – informacje o stokach narciarskich

<img width="1149" height="446" alt="image" src="https://github.com/user-attachments/assets/971a48fa-070b-4a72-9e66-12518f8ad904" />



