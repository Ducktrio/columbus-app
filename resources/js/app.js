import "./bootstrap";

import "bootstrap/dist/js/bootstrap.bundle.min.js";
document.querySelectorAll('.toast').forEach(toastEl => {
    new bootstrap.Toast(toastEl, { delay: 3000 }).show();
});

import p5 from 'p5';

import TOPOLOGY from 'vanta/dist/vanta.topology.min';
let effect;
document.addEventListener('DOMContentLoaded', () => {
  if(effect) effect.destroy()
  effect = TOPOLOGY({
    el: "#bg-animate",
    p5: p5,
    backgroundColor: 0xffffff
  })
})