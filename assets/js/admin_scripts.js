/*     
   Name:       Louwrens Költzow
   Student     Number: V9T2LDZZ1
   Campus:     Pretoria
   Module:     ITECA3-B12: Project Final
*/

const navbar = document.querySelector('.header .flex .navbar');
const profile = document.querySelector('.header .flex .profile');
const menuBtn = document.querySelector('#menu-btn');
const userBtn = document.querySelector('#user-btn');
const mainImage = document.querySelector('.update-product .image-container .main-image img');
const subImagesContainer = document.querySelector('.update-product .image-container .sub-image');

// Navbar Visibility
menuBtn.onclick = () => {
   navbar.classList.toggle('active');
   profile.classList.remove('active');
}

// Profile Visibility
userBtn.onclick = () => {
   profile.classList.toggle('active');
   navbar.classList.remove('active');
}

// Active Scroll
window.onscroll = () => {
   navbar.classList.remove('active');
   profile.classList.remove('active');
}

// Event Images
if (subImagesContainer) {
   subImagesContainer.onclick = (event) => {
      if (event.target.tagName === 'IMG') {
         const src = event.target.getAttribute('src');
         mainImage.src = src;
      }
   }
}
