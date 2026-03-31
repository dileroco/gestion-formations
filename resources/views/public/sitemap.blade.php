<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/fr') }}</loc>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{{ url('/en') }}</loc>
        <priority>1.0</priority>
    </url>
    
    <!-- Formations FR -->
    @foreach($formations as $formation)
    <url>
        <loc>{{ route('fr.formations.show', $formation->slug_fr) }}</loc>
        <lastmod>{{ $formation->updated_at->toAtomString() }}</lastmod>
        <priority>0.8</priority>
    </url>
    @endforeach

    <!-- Formations EN -->
    @foreach($formations as $formation)
    <url>
        <loc>{{ route('en.formations.show', $formation->slug_en) }}</loc>
        <lastmod>{{ $formation->updated_at->toAtomString() }}</lastmod>
        <priority>0.8</priority>
    </url>
    @endforeach

    <!-- Posts FR -->
    @foreach($posts as $post)
    <url>
        <loc>{{ route('fr.blog.show', $post->slug_fr) }}</loc>
        <lastmod>{{ $post->updated_at->toAtomString() }}</lastmod>
        <priority>0.6</priority>
    </url>
    @endforeach

    <!-- Posts EN -->
    @foreach($posts as $post)
    <url>
        <loc>{{ route('en.blog.show', $post->slug_en) }}</loc>
        <lastmod>{{ $post->updated_at->toAtomString() }}</lastmod>
        <priority>0.6</priority>
    </url>
    @endforeach
</urlset>
