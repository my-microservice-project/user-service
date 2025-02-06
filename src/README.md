# User Service

Bu proje, kullanıcı yönetimi için geliştirilmiş bir mikroservis uygulamasıdır.

## Teknolojiler

- PHP 8.3
- Laravel Framework
- PostgreSQL 14
- Nginx
- Docker

## Kurulum

### Gereksinimler

- Docker
- Docker Compose

### Kurulum Adımları

1. Projeyi klonlayın
```bash
git clone https://github.com/my-microservice-project/user-service
```

2. Proje dizinine gidin
```bash
cd user-service
```

3. .env dosyasını oluşturun
```bash
cp .env.example .env
```

3. src dizinine gidin
```bash
cd src
```

4. ./src klasöründe de .env dosyasını oluşturun
```bash
cp .env.example .env
```

5. Proje kök dizinine geçerek docker konteynerlerini başlatın
```bash
cd ..
docker-compose up -d
```

## Docker Servisleri

Proje aşağıdaki Docker servislerini içermektedir:

1. **webserver**: Nginx web sunucusu
    - Port: .env dosyasında belirtilen WEBSERVICE_PORT (varsayılan: 80)
    - Alpine tabanlı hafif bir Nginx image'ı kullanır

2. **php-fpm**: PHP-FPM sunucusu
    - PHP 8.3 versiyonu
    - Özel PHP yapılandırmaları için override dosyası içerir

3. **postgresql**: PostgreSQL veritabanı
    - Version: 14
    - Port: .env dosyasında belirtilen POSTGRES_PORT (varsayılan: 5432)
    - Veriler "./data/postgresql_data" dizininde persist edilir

## API Endpointleri

### 1. Kullanıcıları Listele
- **Endpoint**: `GET /api/v1/users`
- **Açıklama**: Sistemdeki tüm kullanıcıları listeler
- **Başarılı Yanıt**: 200 OK

### 2. Kullanıcı Oluştur
- **Endpoint**: `POST /api/v1/users`
- **Açıklama**: Yeni bir kullanıcı oluşturur
- **İstek Gövdesi**:
  ```json
  {
    "name": "John",
    "last_name": "Doe",
    "email": "johndoe@example.com",
    "password": "123456789"
  }
  ```
- **Başarılı Yanıt**: 202 Accepted

### 3. Kullanıcı Doğrulama
- **Endpoint**: `POST /api/v1/users/verify`
- **Açıklama**: Kullanıcı kimlik bilgilerini doğrular
- **İstek Gövdesi**:
  ```json
  {
    "email": "johndoe@example.com",
    "password": "123456789"
  }
  ```
- **Başarılı Yanıt**: 200 OK

## Notlar

- Tüm servisler `shared_network` adlı bir Docker network'ü üzerinde çalışır
- Veritabanı bilgileri `.env` dosyasında yapılandırılmalıdır
- Nginx yapılandırması `docker/nginx/nginx.conf` dosyasında bulunur
- PHP özel yapılandırmaları `docker/php-fpm/php-ini-overrides.ini` dosyasında bulunur 
