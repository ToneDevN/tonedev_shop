{{--
    Toast Notification Component
    ใช้งาน: <x-toast /> ใน layout
    เรียก toast จาก JS: showToast('ข้อความ')  หรือ  showToast('ข้อความ', 'error')
    Types: success | error | warning | info
--}}

<div
    x-data="{
        toasts: [],
        add(message, type = 'success') {
            const id = Date.now();
            this.toasts.push({ id, message, type, visible: true });
            setTimeout(() => this.dismiss(id), 4000);
        },
        dismiss(id) {
            const t = this.toasts.find(t => t.id === id);
            if (t) t.visible = false;
            setTimeout(() => this.toasts = this.toasts.filter(t => t.id !== id), 350);
        }
    }"
    x-on:show-toast.window="add($event.detail.message, $event.detail.type)"
    class="fixed bottom-4 right-4 z-50 flex flex-col gap-2 w-80"
    role="region"
    aria-live="polite"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-show="toast.visible"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
            class="flex items-start gap-3 px-4 py-3 rounded-xl shadow-lg border text-sm font-medium"
            :class="{
                'bg-emerald-50 border-emerald-200 text-emerald-800': toast.type === 'success',
                'bg-rose-50    border-rose-200    text-rose-800':    toast.type === 'error',
                'bg-amber-50   border-amber-200   text-amber-800':   toast.type === 'warning',
                'bg-blue-50    border-blue-200    text-blue-800':    toast.type === 'info',
            }"
        >
            <svg x-show="toast.type === 'success'" class="w-5 h-5 shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <svg x-show="toast.type === 'error'"   class="w-5 h-5 shrink-0 text-rose-500"    fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <svg x-show="toast.type === 'warning'" class="w-5 h-5 shrink-0 text-amber-500"   fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
            <svg x-show="toast.type === 'info'"    class="w-5 h-5 shrink-0 text-blue-500"    fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>

            <span class="flex-1" x-text="toast.message"></span>

            <button x-on:click="dismiss(toast.id)" class="shrink-0 opacity-40 hover:opacity-100 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </template>
</div>

<script>
function showToast(message, type = 'success') {
    window.dispatchEvent(new CustomEvent('show-toast', { detail: { message, type } }));
}
</script>
