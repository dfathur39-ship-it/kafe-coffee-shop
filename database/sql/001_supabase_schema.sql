-- ============================================================
-- KAFE COFFEE SHOP — Skema Database PostgreSQL (Supabase)
-- Jalankan di: Supabase Dashboard → SQL Editor → New Query
-- ============================================================

-- Ekstensi UUID (opsional, jika ingin pakai UUID di masa depan)
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- ------------------------------------------------------------
-- 1. USERS (extend tabel bawaan Laravel / buat dari awal)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id              BIGSERIAL PRIMARY KEY,
    name            VARCHAR(255) NOT NULL,
    email           VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password        VARCHAR(255) NOT NULL,
    role            VARCHAR(20) NOT NULL DEFAULT 'customer'
                    CHECK (role IN ('admin', 'customer')),
    phone           VARCHAR(20) NULL,
    address         TEXT NULL,
    remember_token  VARCHAR(100) NULL,
    created_at      TIMESTAMP NULL DEFAULT NOW(),
    updated_at      TIMESTAMP NULL DEFAULT NOW()
);

CREATE INDEX IF NOT EXISTS idx_users_role ON users(role);
CREATE INDEX IF NOT EXISTS idx_users_email ON users(email);

-- ------------------------------------------------------------
-- 2. CATEGORIES
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS categories (
    id              BIGSERIAL PRIMARY KEY,
    nama_kategori   VARCHAR(100) NOT NULL UNIQUE,
    slug            VARCHAR(120) NOT NULL UNIQUE,
    created_at      TIMESTAMP NULL DEFAULT NOW(),
    updated_at      TIMESTAMP NULL DEFAULT NOW()
);

-- ------------------------------------------------------------
-- 3. PRODUCTS
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS products (
    id              BIGSERIAL PRIMARY KEY,
    category_id     BIGINT NOT NULL REFERENCES categories(id) ON DELETE RESTRICT,
    nama_produk     VARCHAR(255) NOT NULL,
    deskripsi       TEXT NULL,
    harga           DECIMAL(12, 2) NOT NULL CHECK (harga >= 0),
    foto            VARCHAR(500) NULL,
    stok_status     VARCHAR(20) NOT NULL DEFAULT 'tersedia'
                    CHECK (stok_status IN ('tersedia', 'habis')),
    is_featured     BOOLEAN NOT NULL DEFAULT FALSE,
    created_at      TIMESTAMP NULL DEFAULT NOW(),
    updated_at      TIMESTAMP NULL DEFAULT NOW()
);

CREATE INDEX IF NOT EXISTS idx_products_category ON products(category_id);
CREATE INDEX IF NOT EXISTS idx_products_featured ON products(is_featured);
CREATE INDEX IF NOT EXISTS idx_products_stok ON products(stok_status);

-- ------------------------------------------------------------
-- 4. ORDERS
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS orders (
    id                  BIGSERIAL PRIMARY KEY,
    user_id             BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    total_harga         DECIMAL(12, 2) NOT NULL CHECK (total_harga >= 0),
    status_pesanan      VARCHAR(30) NOT NULL DEFAULT 'pending'
                        CHECK (status_pesanan IN (
                            'pending', 'diproses', 'siap', 'selesai', 'dibatalkan'
                        )),
    tipe_pesanan        VARCHAR(20) NOT NULL DEFAULT 'dine_in'
                        CHECK (tipe_pesanan IN ('dine_in', 'takeaway')),
    nomor_meja          VARCHAR(20) NULL,
    alamat_pengiriman   TEXT NULL,
    metode_pembayaran   VARCHAR(50) NULL DEFAULT 'cash',
    payment_status      VARCHAR(30) NOT NULL DEFAULT 'pending'
                        CHECK (payment_status IN ('pending', 'paid', 'failed', 'refunded')),
    catatan             TEXT NULL,
    created_at          TIMESTAMP NULL DEFAULT NOW(),
    updated_at          TIMESTAMP NULL DEFAULT NOW()
);

CREATE INDEX IF NOT EXISTS idx_orders_user ON orders(user_id);
CREATE INDEX IF NOT EXISTS idx_orders_status ON orders(status_pesanan);
CREATE INDEX IF NOT EXISTS idx_orders_created ON orders(created_at);

-- ------------------------------------------------------------
-- 5. ORDER ITEMS
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS order_items (
    id              BIGSERIAL PRIMARY KEY,
    order_id        BIGINT NOT NULL REFERENCES orders(id) ON DELETE CASCADE,
    product_id      BIGINT NOT NULL REFERENCES products(id) ON DELETE RESTRICT,
    kuantitas       INTEGER NOT NULL CHECK (kuantitas > 0),
    harga_satuan    DECIMAL(12, 2) NOT NULL CHECK (harga_satuan >= 0),
    catatan         TEXT NULL,
    created_at      TIMESTAMP NULL DEFAULT NOW(),
    updated_at      TIMESTAMP NULL DEFAULT NOW()
);

CREATE INDEX IF NOT EXISTS idx_order_items_order ON order_items(order_id);
CREATE INDEX IF NOT EXISTS idx_order_items_product ON order_items(product_id);

-- ------------------------------------------------------------
-- 6. TABEL PENDUKUNG LARAVEL
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS password_reset_tokens (
    email           VARCHAR(255) PRIMARY KEY,
    token           VARCHAR(255) NOT NULL,
    created_at      TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS failed_jobs (
    id              BIGSERIAL PRIMARY KEY,
    uuid            VARCHAR(255) NOT NULL UNIQUE,
    connection      TEXT NOT NULL,
    queue           TEXT NOT NULL,
    payload         TEXT NOT NULL,
    exception       TEXT NOT NULL,
    failed_at       TIMESTAMP NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS personal_access_tokens (
    id              BIGSERIAL PRIMARY KEY,
    tokenable_type  VARCHAR(255) NOT NULL,
    tokenable_id    BIGINT NOT NULL,
    name            VARCHAR(255) NOT NULL,
    token           VARCHAR(64) NOT NULL UNIQUE,
    abilities       TEXT NULL,
    last_used_at    TIMESTAMP NULL,
    expires_at      TIMESTAMP NULL,
    created_at      TIMESTAMP NULL,
    updated_at      TIMESTAMP NULL
);

-- ------------------------------------------------------------
-- 7. SEED DATA AWAL
-- ------------------------------------------------------------
INSERT INTO categories (nama_kategori, slug) VALUES
    ('Coffee',       'coffee'),
    ('Non-Coffee',   'non-coffee'),
    ('Snack',        'snack'),
    ('Makanan Berat', 'makanan-berat')
ON CONFLICT (slug) DO NOTHING;

-- Admin default (password: password — GANTI setelah login pertama!)
INSERT INTO users (name, email, password, role, created_at, updated_at)
VALUES (
    'Admin Kafe',
    'admin@kafe.test',
    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'admin',
    NOW(),
    NOW()
) ON CONFLICT (email) DO NOTHING;

-- Produk unggulan contoh
INSERT INTO products (category_id, nama_produk, deskripsi, harga, foto, stok_status, is_featured)
SELECT
    c.id,
    p.nama_produk,
    p.deskripsi,
    p.harga,
    p.foto,
    'tersedia',
    TRUE
FROM categories c
CROSS JOIN (VALUES
    ('coffee',       'Espresso Klasik',    'Single origin Arabica dengan rasa bold.',           25000, 'products/espresso.jpg'),
    ('coffee',       'Cappuccino Velvet',  'Espresso, susu steamed, dan foam lembut.',          32000, 'products/cappuccino.jpg'),
    ('non-coffee',   'Matcha Latte',       'Matcha premium Jepang dengan susu oat.',            35000, 'products/matcha.jpg'),
    ('snack',        'Croissant Butter',   'Croissant renyah dengan mentega premium.',            28000, 'products/croissant.jpg')
) AS p(slug, nama_produk, deskripsi, harga, foto)
WHERE c.slug = p.slug
ON CONFLICT DO NOTHING;
