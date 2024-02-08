function toggleWorkImages(currentPage) {
    // Hide all work images initially
    document.querySelectorAll('.work-image').forEach((img) => {
        img.style.display = 'none';
    });

    // Show the appropriate image for pages 3, 4, and 5
    if (currentPage === 3) {
        document.querySelector('img[src="img/ptf1.jpg"]').style.display = 'block';
    } else if (currentPage === 4) {
        document.querySelector('img[src="img/ptf2.jpg"]').style.display = 'block';
    } else if (currentPage === 5) {
        document.querySelector('img[src="img/ptf3.jpg"]').style.display = 'block';
    }
    // No images will be shown for currentPage 6 as per the requirement
}

//turn pages when click next or prev button
const pageTurnBtn = document.querySelectorAll('.nextprev-btn');

pageTurnBtn.forEach((el, index) => {
    el.onclick = () => {
        const pageTurnId = el.getAttribute('data-page');
        const pageTurn = document.getElementById(pageTurnId);
        let currentPageNumber = parseInt(pageTurnId.replace('turn-', '')); // Assumes IDs like "turn-1", "turn-2", etc.

        if (pageTurn.classList.contains('turn')) {
            pageTurn.classList.remove('turn');
            setTimeout(() => {
                pageTurn.style.zIndex = 20 - index;
                currentPageNumber -= 1; // Decrement page number when turning back
                toggleWorkImages(currentPageNumber);
            }, 500)
        }
        else {
            pageTurn.classList.add('turn');
            setTimeout(() => {
                pageTurn.style.zIndex = 20 + index;
                currentPageNumber += 1; // Increment page number when moving forward
                toggleWorkImages(currentPageNumber);
            }, 500)
        }
    }
});

//contact me button when click
const pages = document.querySelectorAll('.book-page.page-right');
const contactMeBtn = document.querySelector('.btn.contact-me');

contactMeBtn.onclick = () => {
    pages.forEach((page, index) => {
        setTimeout(() => {
            page.classList.add('turn');

            setTimeout(() => {
                page.style.zIndex = 20 + index;
                toggleWorkImages(index + 2); // Assuming this is the correct page number
            }, 500)

        }, (index + 1) * 200 + 100)
    })
};

//create reverse index function
let totalPages = pages.length;
let pageNumber = 0;

function reverseIndex() {
    pageNumber--;
    if (pageNumber < 0) {
        pageNumber = totalPages - 1;
    }
}

//back profile button when click
const backProfileBtn = document.querySelector('.back-profile');

backProfileBtn.onclick = () => {
    pages.forEach((_, index) => {
        setTimeout(() => {
            reverseIndex();
            pages[pageNumber].classList.remove('turn');

            setTimeout(() => {
                reverseIndex();
                pages[pageNumber].style.zIndex = 10 + index;
                toggleWorkImages(pageNumber); // Update to show the correct image
            }, 500)

        }, (index + 1) * 200 + 100)
    })
};

//opening animation
const coverRight = document.querySelector('.cover.cover-right');
const pageLeft = document.querySelector('.book-page.page-left');

//opening animation (cover right animation)
setTimeout(() => {
    coverRight.classList.add('turn');
}, 2100);

setTimeout(() => {
    coverRight.style.zIndex = -1;
}, 2800);


//opening animation (page left or profile page animation)
setTimeout(() => {
    pageLeft.style.zIndex = 20;
}, 3200)

//opening animation (all page right animation)
pages.forEach((_, index) => {
    setTimeout(() => {
        reverseIndex();
        pages[pageNumber].classList.remove('turn');

        setTimeout(() => {
            reverseIndex();
            pages[pageNumber].style.zIndex = 10 + index;
        }, 500)

    }, (index + 1) * 200 + 2100)
})