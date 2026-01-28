# ANALISIS SKALABILITAS PERANGKAT LUNAK
## Aplikasi Pembayaran Listrik Pascabayar

---

**Unit Kompetensi**: J.620100.002.01 - Menganalisis Skalabilitas Perangkat Lunak  
**Nama Aplikasi**: Aplikasi Listrik Pascabayar  
**Platform**: Web Application (Laravel 12)  
**Tanggal**: 28 Januari 2026

---

## 1. IDENTIFIKASI LINGKUP (SCOPE) SISTEM

### 1.1 Gambaran Umum Sistem
Aplikasi Listrik Pascabayar adalah sistem manajemen pembayaran listrik berbasis web yang memungkinkan PLN mengelola:
- Data pelanggan dan daya listrik
- Pencatatan penggunaan listrik bulanan
- Generate tagihan otomatis
- Pemrosesan pembayaran multi-metode
- Laporan dan dashboard real-time

### 1.2 Fitur Utama Sistem

#### A. Manajemen Pelanggan
- CRUD (Create, Read, Update, Delete) data pelanggan
- Auto-generate ID pelanggan (PEL001, PEL002, ...)
- Manajemen daya listrik (450VA - 3500VA)
- Status pelanggan (Aktif, Nonaktif, Suspend)
- Auto-create akun user untuk pelanggan

#### B. Pencatatan Penggunaan
- Input meter awal dan akhir per bulan
- Auto-calculate total kWh
- Validasi periode (mencegah duplikasi)
- Ambil meter akhir sebagai meter awal periode berikutnya

#### C. Sistem Tagihan
- Generate tagihan otomatis via database trigger
- Perhitungan tarif per kWh berdasarkan daya
- Sistem denda 2% per bulan untuk keterlambatan
- Jatuh tempo 20 hari dari tanggal tagihan
- Status: Belum Bayar, Sudah Bayar, Terlambat

#### D. Pembayaran
- Multi metode: Tunai, Transfer, EDC, QRIS
- Update status tagihan otomatis
- Cetak struk pembayaran
- Validasi jumlah pembayaran

#### E. Laporan & Dashboard
- Dashboard statistik real-time
- Grafik pendapatan bulanan
- Laporan penggunaan, pembayaran, tunggakan
- Laporan pelanggan per kategori daya

### 1.3 Aktor/Pengguna Sistem

| Level | Jumlah User | Hak Akses |
|-------|-------------|-----------|
| **Admin** | 1-5 | Full access ke seluruh sistem |
| **Operator** | 10-50 | Kelola pelanggan, tagihan, pembayaran |
| **Pelanggan** | 1,000-100,000+ | View data pribadi, tagihan, riwayat |

---

## 2. IDENTIFIKASI LINGKUNGAN OPERASI APLIKASI

### 2.1 Arsitektur Sistem
**Tipe**: Web-based Client-Server Architecture

```
┌─────────────────┐
│   Web Browser   │ ← Client (Pelanggan, Operator, Admin)
│   (Chrome, FF)  │
└────────┬────────┘
         │ HTTPS
         │
┌────────▼────────┐
│   Web Server    │
│   (Apache/Nginx)│
│   + PHP 8.2     │
│   + Laravel 12  │
└────────┬────────┘
         │
┌────────▼────────┐
│  Database Server│
│   MySQL 8.0     │
└─────────────────┘
```

### 2.2 Spesifikasi Teknis

#### Stack Teknologi
- **Backend**: PHP 8.2 + Laravel 12
- **Frontend**: Blade Template Engine, Bootstrap 5, JavaScript
- **Database**: MySQL 8.0
- **Web Server**: Apache/Nginx
- **Session Storage**: File-based / Redis (optional)

#### Platform Deployment
- **Development**: Local (XAMPP/Laragon)
- **Production**: 
  - Cloud Server (AWS EC2, DigitalOcean, VPS)
  - Shared Hosting (untuk skala kecil)
  - On-Premise Server (untuk PLN internal)

### 2.3 Skenario Operasi

| Skenario | Skala | Karakteristik |
|----------|-------|---------------|
| **Desktop (Small)** | 1-100 pelanggan | Single server, LAN network, 1-5 concurrent users |
| **Client-Server (Medium)** | 100-5,000 pelanggan | Dedicated server, local network, 10-50 concurrent users |
| **Web-based (Large)** | 5,000-100,000+ pelanggan | Cloud/data center, internet access, 100-1,000+ concurrent users |

---

## 3. ANALISIS MASALAH SKALABILITAS

### 3.1 Berdasarkan Lingkup Sistem

#### A. Skalabilitas Data
**Masalah Potensial**:
- Pertumbuhan data pelanggan: +1,000 pelanggan/tahun
- Penggunaan listrik: 12 record/pelanggan/tahun
- Tagihan: 12 record/pelanggan/tahun
- Pembayaran: 12 record/pelanggan/tahun

**Estimasi Volume Data (5 tahun)**:

| Tabel | Record/tahun | Total 5 tahun |
|-------|--------------|---------------|
| Pelanggan | 1,000 | 5,000 |
| Penggunaan | 12,000 | 60,000 |
| Tagihan | 12,000 | 60,000 |
| Pembayaran | 12,000 | 60,000 |
| **TOTAL** | **37,000** | **185,000 records** |

**Solusi**:
- Database indexing pada kolom pencarian (id_pelanggan, bulan, tahun)
- Archiving data lama (>3 tahun) ke tabel history
- Database partitioning berdasarkan tahun

#### B. Skalabilitas Pengguna
**Masalah Potensial**:
- Peak load saat akhir bulan (deadline pembayaran)
- Concurrent access operator saat jam kerja
- Pelanggan akses bersamaan untuk cek tagihan

**Estimasi Concurrent Users**:
- Operator: 10-50 (jam kerja 08:00-16:00)
- Pelanggan: 100-500 (peak: tanggal 15-20 setiap bulan)
- Admin: 1-5 (monitoring berkala)

**Solusi**:
- Session management dengan Redis
- Query caching untuk data statis
- Load balancing untuk traffic tinggi
- CDN untuk asset statis

#### C. Skalabilitas Transaksi
**Masalah Potensial**:
- Generate tagihan bulk (semua pelanggan per bulan)
- Proses pembayaran concurrent
- Report generation dengan data besar

**Solusi**:
- Queue system (Laravel Queue) untuk batch processing
- Async processing untuk report generation
- Database transaction untuk data integrity

### 3.2 Berdasarkan Lingkungan Operasi

#### Desktop (1-100 pelanggan)
**Karakteristik**:
- Single server, akses lokal
- Minimal concurrent users (1-5)
- Data volume: <10,000 records

**Kendala**:
- Limited hardware resources
- No backup/redundancy
- Single point of failure

**Rekomendasi**:
- Database backup schedule harian
- UPS untuk power stability
- Local file backup

#### Client-Server (100-5,000 pelanggan)
**Karakteristik**:
- Dedicated server, LAN network
- Medium concurrent users (10-50)
- Data volume: 10,000-500,000 records

**Kendala**:
- Network bottleneck pada switch
- Server resource limitation
- Database lock pada peak time

**Rekomendasi**:
- Gigabit network infrastructure
- Database query optimization
- Server upgrade (RAM, SSD)

#### Web-based (5,000-100,000+ pelanggan)
**Karakteristik**:
- Cloud/datacenter, internet access
- High concurrent users (100-1,000+)
- Data volume: 500,000-10,000,000+ records

**Kendala**:
- High bandwidth consumption
- Database connection pool limit
- Application response time degradation

**Rekomendasi**:
- Horizontal scaling (multiple app servers)
- Database read replica
- Redis/Memcached for caching
- CDN for static assets
- Load balancer (Nginx, HAProxy)

---

## 4. ANALISIS KOMPLEKSITAS APLIKASI

### 4.1 Kompleksitas Pemrosesan

#### A. Operasi CRUD Sederhana
**Complexity**: O(1) - Constant time
- Login/Logout user
- View single record
- Insert/Update single record

**Karakteristik**:
- Direct database query dengan primary key
- Minimal processing logic
- Response time: <100ms

#### B. Operasi dengan Filtering/Sorting
**Complexity**: O(n log n) - Linearithmic time
- List pelanggan dengan search & sort
- Laporan dengan filter tanggal
- Dashboard dengan aggregation

**Karakteristik**:
- Database query dengan WHERE, ORDER BY
- Indexed column untuk optimasi
- Response time: 100-500ms

#### C. Batch Processing
**Complexity**: O(n) - Linear time
- Generate tagihan bulk semua pelanggan
- Export laporan Excel
- Backup database

**Karakteristik**:
- Loop processing untuk setiap record
- Queue system untuk async processing
- Processing time: 1-10 menit (tergantung volume)

**Contoh: Generate Tagihan Bulanan**
```
FOR EACH pelanggan IN database:
    penggunaan = GET last_month_usage(pelanggan)
    IF penggunaan EXISTS:
        tagihan = CALCULATE tarif * kwh
        denda = CALCULATE late_fee IF overdue
        INSERT tagihan_baru(pelanggan, jumlah, denda)
END FOR
```
- Time Complexity: O(n) dimana n = jumlah pelanggan
- Space Complexity: O(1) per iterasi

#### D. Reporting & Analytics
**Complexity**: O(n) - Linear time (dengan indexing)
- Laporan penggunaan per periode
- Grafik pendapatan bulanan
- Statistik dashboard

**Karakteristik**:
- Aggregate functions (SUM, AVG, COUNT)
- GROUP BY untuk kategorisasi
- Query optimization dengan index
- Response time: 500ms-2s

### 4.2 Estimasi Beban Pemrosesan

| Operasi | Frequency | Complexity | Impact |
|---------|-----------|------------|--------|
| Login User | 100-500/hari | O(1) | Low |
| View Tagihan | 500-2,000/hari | O(1) | Low |
| Input Penggunaan | 100-500/hari | O(1) | Low |
| Proses Pembayaran | 50-200/hari | O(1) | Medium |
| Generate Tagihan Bulk | 1/bulan | O(n) | High |
| Generate Laporan | 10-50/hari | O(n log n) | Medium-High |

### 4.3 Analisis Kebutuhan Memori

#### RAM Requirements

**Development/Small Scale (1-100 users)**:
- PHP Memory Limit: 128MB per request
- Database Buffer: 256MB
- OS + Web Server: 512MB
- **Total**: **2GB RAM minimum**

**Medium Scale (100-5,000 users)**:
- PHP Workers: 512MB (multiple processes)
- Database Buffer: 1GB
- Redis Cache: 512MB
- OS + Services: 1GB
- **Total**: **4GB RAM minimum**

**Large Scale (5,000+ users)**:
- PHP-FPM Workers: 2GB (50-100 workers)
- Database Buffer Pool: 4-8GB
- Redis Cache: 2GB
- OS + Services: 2GB
- **Total**: **16GB RAM minimum**

#### Storage Requirements

**Database Growth per 1,000 pelanggan/tahun**:
```
Pelanggan: 1,000 records × 1KB = 1MB
Penggunaan: 12,000 records × 500 bytes = 6MB
Tagihan: 12,000 records × 800 bytes = 9.6MB
Pembayaran: 12,000 records × 600 bytes = 7.2MB
Total: ~24MB/tahun/1,000 pelanggan
```

**Proyeksi 5 tahun (10,000 pelanggan)**:
- Database: 24MB × 10 × 5 = **1.2GB**
- Backup: 1.2GB × 3 = **3.6GB**
- Logs: **500MB**
- Application Files: **200MB**
- **Total**: **~6GB storage minimum**

---

## 5. ANALISIS KEBUTUHAN PERANGKAT KERAS

### 5.1 Spesifikasi Server untuk Berbagai Skala

#### Small Scale (1-100 Pelanggan)
**Deployment**: Shared Hosting / VPS Basic / Local Server

| Komponen | Spesifikasi | Keterangan |
|----------|-------------|------------|
| **Processor** | 2 vCPU / Core i3 | Single thread performance |
| **RAM** | 2-4 GB | Cukup untuk PHP + MySQL |
| **Storage** | 20 GB SSD | Fast disk I/O |
| **Network** | 10 Mbps | Local/internet access |
| **OS** | Ubuntu 22.04 / Windows Server | Linux preferred |

**Estimasi Biaya**:
- VPS: $5-10/bulan (DigitalOcean, Vultr)
- Local: $300-500 (sekali)

---

#### Medium Scale (100-5,000 Pelanggan)
**Deployment**: VPS / Dedicated Server / Cloud

| Komponen | Spesifikasi | Keterangan |
|----------|-------------|------------|
| **Processor** | 4 vCPU / Core i5 | Multi-core for concurrent |
| **RAM** | 8-16 GB | Handle 50+ concurrent users |
| **Storage** | 100 GB SSD | Database + backups |
| **Network** | 100 Mbps | Support web traffic |
| **OS** | Ubuntu 22.04 LTS | Stable & secure |

**Additional Components**:
- **Backup Server**: 200GB HDD for daily backup
- **UPS**: 1000VA untuk power backup
- **Network Switch**: Gigabit 24-port

**Estimasi Biaya**:
- VPS/Cloud: $40-80/bulan (AWS t3.large, DO)
- Dedicated: $1,500-3,000 (sekali)

---

#### Large Scale (5,000-100,000+ Pelanggan)
**Deployment**: Cloud Infrastructure (Multi-server)

**Application Server (Load Balanced - 2+ instances)**

| Komponen | Spesifikasi | Keterangan |
|----------|-------------|------------|
| **Processor** | 8 vCPU | Handle heavy PHP processing |
| **RAM** | 16-32 GB | PHP-FPM workers |
| **Storage** | 50 GB SSD | Application code |
| **Network** | 1 Gbps | High bandwidth |

**Database Server (Primary + Replica)**

| Komponen | Spesifikasi | Keterangan |
|----------|-------------|------------|
| **Processor** | 8-16 vCPU | Complex query processing |
| **RAM** | 32-64 GB | InnoDB buffer pool |
| **Storage** | 500 GB SSD | Database + index |
| **IOPS** | 3,000+ | Fast read/write |

**Cache Server (Redis)**

| Komponen | Spesifikasi | Keterangan |
|----------|-------------|------------|
| **Processor** | 2-4 vCPU | In-memory operations |
| **RAM** | 8-16 GB | Session + cache storage |
| **Storage** | 20 GB SSD | Persistence |

**Infrastructure Components**:
- **Load Balancer**: Nginx / AWS ELB / Cloudflare
- **CDN**: Cloudflare / AWS CloudFront (static assets)
- **Backup Storage**: S3 / Backup server 1TB
- **Monitoring**: New Relic / Datadog / Prometheus

**Estimasi Biaya**:
- Cloud Infrastructure: $300-1,000/bulan
- AWS/Azure/GCP recommended

---

### 5.2 Network Infrastructure

#### Small Scale
- **Internet**: 10 Mbps dedicated
- **Router**: Consumer grade (TP-Link, Mikrotik)
- **Firewall**: Software-based (UFW, iptables)

#### Medium Scale
- **Internet**: 100 Mbps dedicated
- **LAN**: Gigabit Ethernet
- **Router**: Enterprise (Cisco, Mikrotik)
- **Switch**: Managed L2 Switch 24-port
- **Firewall**: Hardware firewall (Sophos, Fortinet)

#### Large Scale
- **Internet**: 1 Gbps+ (redundant ISP)
- **LAN**: 10 Gbps backbone
- **Load Balancer**: Dedicated (F5, Nginx Plus)
- **CDN**: Global (Cloudflare, AWS CloudFront)
- **DDoS Protection**: Cloudflare, AWS Shield
- **Firewall**: Enterprise WAF (Web Application Firewall)

---

## 6. DOKUMENTASI HASIL ANALISIS

### 6.1 Ringkasan Skalabilitas

| Aspek | Small | Medium | Large |
|-------|-------|--------|-------|
| **Pelanggan** | 1-100 | 100-5,000 | 5,000-100,000+ |
| **Concurrent Users** | 1-10 | 10-50 | 100-1,000+ |
| **Data Volume** | <10K records | 10K-500K | 500K-10M+ |
| **Server** | Single VPS | Dedicated | Multi-server Cloud |
| **RAM** | 2-4 GB | 8-16 GB | 32-128 GB (total) |
| **Storage** | 20 GB | 100 GB | 500 GB+ |
| **Bandwidth** | 10 Mbps | 100 Mbps | 1 Gbps+ |
| **Monthly Cost** | $5-20 | $50-150 | $300-1,000+ |

### 6.2 Strategi Scaling

#### Vertical Scaling (Scale Up)
- Upgrade CPU, RAM, Storage pada server yang sama
- Cocok untuk small → medium scale
- **Limit**: Hardware limitation

#### Horizontal Scaling (Scale Out)
- Tambah server/instance baru
- Load balancing traffic
- Database replication
- Cocok untuk medium → large scale
- **Benefit**: No downtime, unlimited scale

### 6.3 Best Practices Implementasi

#### Performance Optimization
1. **Database Indexing**
   - Index pada foreign keys (id_pelanggan, id_tarif)
   - Composite index untuk query kompleks
   
2. **Query Caching**
   - Laravel Query Cache untuk data statis
   - Redis untuk session & cache
   
3. **Lazy Loading**
   - Load data on-demand (pagination)
   - Eager loading untuk relasi N+1
   
4. **Asset Optimization**
   - Minify CSS/JS
   - Image compression
   - CDN untuk static files

#### Reliability & Availability
1. **Backup Strategy**
   - Daily database backup (automated)
   - Weekly full system backup
   - Off-site backup storage
   
2. **Monitoring**
   - Server resource monitoring (CPU, RAM, Disk)
   - Application performance monitoring (APM)
   - Error logging & alerting
   
3. **High Availability**
   - Database replication (master-slave)
   - Application redundancy (multiple instances)
   - Load balancer health check

#### Security
1. **Data Protection**
   - SSL/TLS encryption (HTTPS)
   - Database encryption at rest
   - Password hashing (bcrypt)
   
2. **Access Control**
   - Role-based access control (RBAC)
   - Two-factor authentication (2FA)
   - API rate limiting

---

## 7. KESIMPULAN DAN REKOMENDASI

### 7.1 Kesimpulan

1. **Aplikasi Listrik Pascabayar** memiliki potensi skalabilitas tinggi dari small (100 pelanggan) hingga enterprise scale (100,000+ pelanggan)

2. **Kompleksitas operasi** tergolong medium dengan dominasi operasi O(1) dan O(n), dapat ditangani dengan optimasi database dan caching

3. **Bottleneck utama** berada pada:
   - Database query untuk laporan kompleks
   - Batch processing tagihan bulanan
   - Concurrent user access saat peak time

4. **Infrastruktur** dapat disesuaikan secara bertahap sesuai pertumbuhan:
   - **Phase 1**: Single VPS (1-100 pelanggan)
   - **Phase 2**: Dedicated Server (100-5,000 pelanggan)
   - **Phase 3**: Cloud Multi-server (5,000+ pelanggan)

### 7.2 Rekomendasi

#### Immediate (Development Phase)
1. ✅ Implementasi database indexing
2. ✅ Setup query caching (Redis)
3. ✅ Pagination untuk list data
4. ✅ Lazy loading untuk relasi

#### Short-term (0-6 bulan)
1. Deploy ke VPS dengan minimum spec (2GB RAM)
2. Setup automated backup system
3. Implementasi monitoring (Laravel Telescope)
4. Load testing dengan 50-100 concurrent users

#### Mid-term (6-12 bulan)
1. Upgrade server sesuai growth (4-8GB RAM)
2. Implementasi queue system untuk batch processing
3. Database optimization & archiving
4. CDN untuk static assets

#### Long-term (1-3 tahun)
1. Migration ke cloud infrastructure
2. Horizontal scaling dengan load balancer
3. Database replication (master-slave)
4. Microservices architecture (optional)

### 7.3 Roadmap Skalabilitas

```
Year 0 (Now)          Year 1              Year 2              Year 3
│                     │                   │                   │
│ 100 users          │ 1,000 users       │ 5,000 users       │ 20,000+ users
│ VPS 2GB            │ VPS 8GB           │ Dedicated 16GB    │ Cloud Multi-server
│ $10/mo             │ $40/mo            │ $150/mo           │ $500+/mo
│                    │                   │                   │
│ Single Server  ────┼─→ Optimized   ────┼─→ Replica DB  ────┼─→ Load Balanced
│                    │                   │                   │
└────────────────────┴───────────────────┴───────────────────┘
```

---

## 8. LAMPIRAN

### 8.1 Database Schema Optimization

**Indexed Columns**:
```sql
-- Pelanggan
CREATE INDEX idx_pelanggan_status ON pelanggan(status);
CREATE INDEX idx_pelanggan_daya ON pelanggan(id_daya);

-- Penggunaan
CREATE INDEX idx_penggunaan_periode ON penggunaan(bulan, tahun);
CREATE INDEX idx_penggunaan_pelanggan ON penggunaan(id_pelanggan);

-- Tagihan
CREATE INDEX idx_tagihan_status ON tagihan(status);
CREATE INDEX idx_tagihan_periode ON tagihan(bulan, tahun);
CREATE INDEX idx_tagihan_pelanggan ON tagihan(id_pelanggan);

-- Pembayaran
CREATE INDEX idx_pembayaran_tanggal ON pembayaran(tanggal_bayar);
CREATE INDEX idx_pembayaran_tagihan ON pembayaran(id_tagihan);
```

### 8.2 Cache Strategy

**Redis Cache Keys**:
```
- tarif:all                  → Cache semua tarif (TTL: 24 jam)
- daya:all                   → Cache semua daya listrik (TTL: 24 jam)
- pelanggan:{id}             → Cache data pelanggan (TTL: 1 jam)
- dashboard:stats            → Cache statistik dashboard (TTL: 5 menit)
- laporan:pendapatan:{month} → Cache laporan bulanan (TTL: 1 hari)
```

### 8.3 Performance Metrics Target

| Metric | Target | Acceptable | Poor |
|--------|--------|------------|------|
| Page Load Time | <1s | 1-3s | >3s |
| Database Query | <50ms | 50-200ms | >200ms |
| API Response | <200ms | 200-500ms | >500ms |
| Server CPU | <50% | 50-70% | >70% |
| Server RAM | <60% | 60-80% | >80% |
| Uptime | 99.9% | 99% | <99% |

---

**Prepared by**: [Nama Asesi]  
**Date**: 28 Januari 2026  
**Version**: 1.0  
**Status**: Ready for Presentation
