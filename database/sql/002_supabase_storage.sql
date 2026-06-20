-- ============================================================
-- Supabase Storage: bucket untuk foto menu
-- Jalankan di SQL Editor Supabase ATAU via: php artisan kafe:setup-storage
-- ============================================================

INSERT INTO storage.buckets (id, name, public, file_size_limit, allowed_mime_types)
VALUES (
    'menu-images',
    'menu-images',
    true,
    2097152,
    ARRAY['image/jpeg', 'image/png', 'image/webp', 'image/jpg']
)
ON CONFLICT (id) DO UPDATE SET
    public = EXCLUDED.public,
    file_size_limit = EXCLUDED.file_size_limit,
    allowed_mime_types = EXCLUDED.allowed_mime_types;

-- Izinkan baca publik
DROP POLICY IF EXISTS "Public read menu images" ON storage.objects;
CREATE POLICY "Public read menu images"
    ON storage.objects FOR SELECT
    USING (bucket_id = 'menu-images');

-- Izinkan upload/update/delete untuk role authenticated & service (admin app)
DROP POLICY IF EXISTS "Authenticated upload menu images" ON storage.objects;
CREATE POLICY "Authenticated upload menu images"
    ON storage.objects FOR INSERT
    WITH CHECK (bucket_id = 'menu-images');

DROP POLICY IF EXISTS "Authenticated update menu images" ON storage.objects;
CREATE POLICY "Authenticated update menu images"
    ON storage.objects FOR UPDATE
    USING (bucket_id = 'menu-images');

DROP POLICY IF EXISTS "Authenticated delete menu images" ON storage.objects;
CREATE POLICY "Authenticated delete menu images"
    ON storage.objects FOR DELETE
    USING (bucket_id = 'menu-images');
