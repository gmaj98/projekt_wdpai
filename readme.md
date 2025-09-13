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

### ERD (PlantUML)

```plantuml
@startuml
!theme plain

entity "users" as users {
  *id : serial <<PK>>
  --
  username : varchar(50) <<UNIQUE>>
  email : varchar(100) <<UNIQUE>>
  password_hash : text
  role : varchar(20) [default: 'user']
  created_at : timestamp
}

entity "articles" as articles {
  *id : serial <<PK>>
  --
  title : varchar(255)
  content : text
  author : varchar(100)
  image_url : varchar(255)
  created_at : timestamp
}

entity "ranking" as ranking {
  *id : serial <<PK>>
  --
  user_id : int <<FK>>
  points : int [default: 0]
  distance_km : numeric(10,2) [default: 0]
  max_speed_kmh : numeric(10,2) [default: 0]
  created_at : timestamp
}

entity "slopes" as slopes {
  *id : serial <<PK>>
  --
  name : varchar(100)
  location : varchar(100)
  latitude : double precision
  longitude : double precision
  level_green : boolean [default: false]
  level_blue : boolean [default: false]
  level_red : boolean [default: false]
  level_black : boolean [default: false]
  status : boolean [default: true]
}

users ||--o{ ranking : "ma"
users ||--o{ articles : "pisze"
@enduml



