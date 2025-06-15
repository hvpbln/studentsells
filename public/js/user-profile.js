function switchTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(div => div.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    document.getElementById(tabId).classList.add('active');
    event.target.classList.add('active');
}

document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('.star-rating .star');
    const submitButton = document.getElementById('submit-rating');
    const message = document.getElementById('rating-message');
    const userId = document.querySelector('.star-rating')?.dataset.userId;

    if (!stars.length || !userId) return;

    let selected = 0;

    stars.forEach(star => {
        star.addEventListener('mouseenter', function () {
            highlightStars(parseInt(this.dataset.value));
        });

        star.addEventListener('mouseleave', function () {
            highlightStars(selected);
        });

        star.addEventListener('click', function () {
            selected = parseInt(this.dataset.value);
            highlightStars(selected);
            submitButton.style.display = 'inline-block';
            message.style.display = 'none';
        });
    });

    submitButton.addEventListener('click', function () {
        if (selected === 0) return;

        fetch(`/users/${userId}/rate`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ rating: selected })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                message.textContent = data.message;
                message.style.display = 'block';
                message.classList.remove('text-danger');
                submitButton.style.display = 'none';
            } else {
                message.textContent = data.message || 'Rating failed';
                message.style.display = 'block';
                message.classList.add('text-danger');
            }
        })
        .catch(() => {
            message.textContent = 'Error submitting rating.';
            message.style.display = 'block';
            message.classList.add('text-danger');
        });
    });

    function highlightStars(rating) {
        stars.forEach(star => {
            star.classList.remove('selected');
            if (parseInt(star.dataset.value) <= rating) {
                star.classList.add('selected');
            }
        });
    }
});
