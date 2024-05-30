const navbar = document.querySelector('.header .flex .navbar');
const profile = document.querySelector('.header .flex .profile');
const menuBtn = document.querySelector('#menu-btn');
const userBtn = document.querySelector('#user-btn');
const mainImage = document.querySelector('.update-product .image-container .main-image img');
const subImagesContainer = document.querySelector('.update-product .image-container .sub-image');

// navbar visibility
menuBtn.onclick = () => {
   navbar.classList.toggle('active');
   profile.classList.remove('active');
}

// profile visibility
userBtn.onclick = () => {
   profile.classList.toggle('active');
   navbar.classList.remove('active');
}

// active scroll
window.onscroll = () => {
   navbar.classList.remove('active');
   profile.classList.remove('active');
}

// event images
if (subImagesContainer) {
   subImagesContainer.onclick = (event) => {
      if (event.target.tagName === 'IMG') {
         const src = event.target.getAttribute('src');
         mainImage.src = src;
      }
   }
}
