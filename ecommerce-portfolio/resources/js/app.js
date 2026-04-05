import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// อย่าเพิ่งรัน start() ทันที เพื่อรอให้ Script ใน Blade ลงทะเบียนข้อมูลก่อน
document.addEventListener('alpine:init', () => {
    // ลงทะเบียนอะไรเพิ่มเติมที่นี่ได้ (ถ้ามี)
});

Alpine.start();
