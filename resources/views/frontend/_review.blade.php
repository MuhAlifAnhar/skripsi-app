<section id="review" class="review section light-background">
    <div class="container section-title" data-aos="fade-up">
        <h2>Review</h2>
        <p><span>Check</span> <span class="description-title">Our Review</span></p>
        <br>
        <div class="card border-0 shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-centered table-hover table-nowrap mb-0 rounded">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Code</th>
                                <th>Rating</th>
                                <th>Komentar</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $review)
                                <tr>
                                    <td>{{ ($reviews->currentPage() - 1) * $reviews->perPage() + $loop->iteration }}
                                    </td>
                                    <td>{{ $review->transaction->code }}</td>
                                    <td>{{ $review->rate }}</td>
                                    <td>{{ $review->comment }}</td>
                                    <td>{{ $review->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>
        </div>

        @if ($reviews->isEmpty())
            <p>Tidak ada review yang ditemukan.</p>
        @endif
    </div>
    </div><!-- End Section Title -->
</section>
