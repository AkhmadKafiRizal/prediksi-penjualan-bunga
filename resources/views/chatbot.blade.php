<x-app-layout>

<style>
/* ══════════════════════════════════════════════════════════
   ASISTEN AI — Chat Page Styles
   Mengikuti design system FloraPredict (pink gradient, Plus Jakarta Sans)
   ══════════════════════════════════════════════════════════ */

:root {
    --ai-pk1: #E8185A;
    --ai-pk2: #F04E8A;
    --ai-pk3: #F87FB5;
    --ai-pk4: #FDB8D4;
    --ai-pk5: #FDE8F2;
    --ai-pk6: #FFF2F8;
    --ai-dark: #1A0A12;
    --ai-muted: #9A7A8A;
    --ai-border: #FCE4EF;
    --ai-surface: #fff;
}

.fp-page-chatbot {
    height: 100%;
    padding-bottom: 16px;
}

.fp-page-chatbot .ai-page {
    height: 100%;
    min-height: 0;
    display: flex;
    flex-direction: column;
}

/* ── Page Header ── */
.ai-header {
    margin-bottom: 16px;
    flex-shrink: 0;
}
.ai-eyebrow {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: var(--ai-pk1);
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.ai-eyebrow-dot {
    width: 7px;
    height: 7px;
    background: var(--ai-pk1);
    border-radius: 50%;
    animation: ai-pulse 2s ease-in-out infinite;
}
@keyframes ai-pulse {
    0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(232,24,90,0.4); }
    50% { opacity: 0.7; box-shadow: 0 0 0 6px rgba(232,24,90,0); }
}
.ai-title {
    font-size: 24px;
    font-weight: 800;
    color: var(--ai-dark);
    line-height: 1.1;
    margin-bottom: 6px;
}
.ai-desc {
    font-size: 13px;
    color: var(--ai-muted);
    line-height: 1.5;
    max-width: 560px;
}

/* ── Quick Questions ── */
.ai-quick-wrap {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 18px;
    flex-shrink: 0;
}
.ai-quick-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 16px;
    background: var(--ai-surface);
    border: 1.5px solid var(--ai-border);
    border-radius: 12px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 12.5px;
    font-weight: 600;
    color: var(--ai-dark);
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
}
.ai-quick-btn:hover:not(:disabled) {
    background: var(--ai-pk6);
    border-color: var(--ai-pk4);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(232,24,90,0.08);
}
.ai-quick-btn:active:not(:disabled) {
    transform: translateY(0);
}
.ai-quick-btn:disabled {
    opacity: 0.55;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}
.ai-quick-icon {
    font-size: 15px;
    flex-shrink: 0;
}

/* ── Chat Container ── */
.ai-chat-container {
    background: var(--ai-surface);
    border: 1px solid var(--ai-border);
    border-radius: 18px;
    display: flex;
    flex-direction: column;
    flex: 1;
    min-height: 0;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(232,24,90,0.04);
}
.ai-chat-container[data-state="loading"] .ai-status-dot {
    background: #F59E0B;
}
.ai-chat-container[data-state="error"] .ai-status-dot {
    background: #EF4444;
    animation: none;
}

/* ── Chat Header ── */
.ai-chat-header {
    padding: 14px 20px;
    border-bottom: 1px solid var(--ai-border);
    display: flex;
    align-items: center;
    gap: 12px;
    background: linear-gradient(135deg, var(--ai-pk6) 0%, #fff 100%);
    flex-shrink: 0;
}
.ai-chat-avatar {
    width: 38px;
    height: 38px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--ai-pk1), var(--ai-pk3));
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(232,24,90,0.2);
}
.ai-chat-info-name {
    font-size: 14px;
    font-weight: 700;
    color: var(--ai-dark);
}
.ai-chat-info-status {
    font-size: 11px;
    color: var(--ai-muted);
    display: flex;
    align-items: center;
    gap: 5px;
    margin-top: 1px;
}
.ai-status-dot {
    width: 6px;
    height: 6px;
    background: #22C55E;
    border-radius: 50%;
    animation: ai-pulse-green 2s ease-in-out infinite;
}
@keyframes ai-pulse-green {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.4; }
}

/* ── Messages Area ── */
.ai-messages {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    scroll-behavior: smooth;
}
.ai-messages::-webkit-scrollbar { width: 5px; }
.ai-messages::-webkit-scrollbar-track { background: transparent; }
.ai-messages::-webkit-scrollbar-thumb { background: var(--ai-pk4); border-radius: 10px; }
.ai-messages::-webkit-scrollbar-thumb:hover { background: var(--ai-pk3); }

/* ── Message Bubbles ── */
.ai-msg {
    display: flex;
    gap: 10px;
    max-width: 82%;
    animation: ai-msgIn 0.3s ease;
}
@keyframes ai-msgIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.ai-msg.user {
    align-self: flex-end;
    flex-direction: row-reverse;
}
.ai-msg-avatar {
    width: 32px;
    height: 32px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 14px;
}
.ai-msg.bot .ai-msg-avatar {
    background: linear-gradient(135deg, var(--ai-pk1), var(--ai-pk3));
    box-shadow: 0 3px 10px rgba(232,24,90,0.15);
}
.ai-msg.user .ai-msg-avatar {
    background: var(--ai-pk5);
    border: 1.5px solid var(--ai-border);
    font-size: 12px;
    font-weight: 700;
    color: var(--ai-pk1);
}
.ai-msg-bubble {
    padding: 12px 16px;
    border-radius: 16px;
    font-size: 13.5px;
    line-height: 1.65;
    color: var(--ai-dark);
    position: relative;
}
.ai-msg.bot .ai-msg-bubble {
    background: var(--ai-pk6);
    border: 1px solid var(--ai-border);
    border-top-left-radius: 4px;
}
.ai-msg.user .ai-msg-bubble {
    background: linear-gradient(135deg, var(--ai-pk1), var(--ai-pk2));
    color: #fff;
    border-top-right-radius: 4px;
    border: none;
    box-shadow: 0 4px 14px rgba(232,24,90,0.2);
}
.ai-msg-time {
    font-size: 10px;
    color: var(--ai-muted);
    margin-top: 5px;
    opacity: 0.7;
}
.ai-msg.user .ai-msg-time {
    color: rgba(255,255,255,0.6);
    text-align: right;
}

/* ── Typing Indicator ── */
.ai-typing {
    display: flex;
    gap: 10px;
    max-width: 82%;
    animation: ai-msgIn 0.3s ease;
}
.ai-typing-bubble {
    padding: 14px 20px;
    background: var(--ai-pk6);
    border: 1px solid var(--ai-border);
    border-radius: 16px;
    border-top-left-radius: 4px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.ai-typing-dots {
    display: flex;
    align-items: center;
    gap: 5px;
}
.ai-typing-text {
    font-size: 12px;
    font-weight: 600;
    color: #7A2A4A;
    white-space: nowrap;
}
.ai-typing-dot {
    width: 7px;
    height: 7px;
    background: var(--ai-pk3);
    border-radius: 50%;
    animation: ai-bounce 1.4s ease-in-out infinite;
}
.ai-typing-dot:nth-child(2) { animation-delay: 0.2s; }
.ai-typing-dot:nth-child(3) { animation-delay: 0.4s; }
@keyframes ai-bounce {
    0%, 60%, 100% { transform: translateY(0); background: var(--ai-pk4); }
    30% { transform: translateY(-8px); background: var(--ai-pk1); }
}

/* ── Error Message ── */
.ai-error {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    background: #FFF5F5;
    border: 1px solid #FECACA;
    border-radius: 12px;
    font-size: 12.5px;
    color: #991B1B;
    animation: ai-msgIn 0.3s ease;
    max-width: 82%;
}
.ai-error-icon {
    flex-shrink: 0;
    width: 28px;
    height: 28px;
    background: #FEE2E2;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
}
.ai-error-retry {
    margin-left: auto;
    padding: 5px 12px;
    background: #FEE2E2;
    border: 1px solid #FECACA;
    border-radius: 8px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 11px;
    font-weight: 700;
    color: #991B1B;
    cursor: pointer;
    transition: all 0.15s;
    flex-shrink: 0;
}
.ai-error-retry:hover {
    background: #FECACA;
}

/* ── Input Area ── */
.ai-input-area {
    padding: 14px 16px;
    border-top: 1px solid var(--ai-border);
    background: #fff;
    flex-shrink: 0;
}
.ai-input-wrap {
    display: flex;
    align-items: flex-end;
    gap: 10px;
    background: var(--ai-pk6);
    border: 1.5px solid var(--ai-border);
    border-radius: 14px;
    padding: 6px 6px 6px 16px;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.ai-input-wrap:focus-within {
    border-color: var(--ai-pk3);
    box-shadow: 0 0 0 3px rgba(232,24,90,0.08);
}
.ai-input {
    flex: 1;
    border: none;
    background: transparent;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13.5px;
    color: var(--ai-dark);
    resize: none;
    outline: none;
    min-height: 22px;
    max-height: 100px;
    padding: 6px 0;
    line-height: 1.5;
}
.ai-input::placeholder {
    color: #8A526C;
    opacity: 1;
}
.ai-send-btn {
    width: 40px;
    height: 40px;
    border-radius: 11px;
    border: none;
    background: linear-gradient(135deg, var(--ai-pk1), var(--ai-pk2));
    color: #fff;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.2s;
    box-shadow: 0 3px 10px rgba(232,24,90,0.25);
}
.ai-send-btn:hover:not(:disabled) {
    transform: translateY(-1px);
    box-shadow: 0 5px 16px rgba(232,24,90,0.35);
}
.ai-send-btn:active:not(:disabled) {
    transform: translateY(0);
}
.ai-send-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    box-shadow: none;
}
.ai-input-hint {
    font-size: 10px;
    color: var(--ai-muted);
    margin-top: 6px;
    padding-left: 4px;
    opacity: 0.6;
}

/* ── Welcome State ── */
.ai-welcome {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    flex: 1;
    text-align: center;
    padding: 40px 20px;
    animation: ai-fadeIn 0.6s ease;
}
@keyframes ai-fadeIn {
    from { opacity: 0; transform: scale(0.96); }
    to { opacity: 1; transform: scale(1); }
}
.ai-welcome-icon {
    width: 72px;
    height: 72px;
    border-radius: 22px;
    background: linear-gradient(135deg, var(--ai-pk1), var(--ai-pk3));
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 18px;
    box-shadow: 0 8px 30px rgba(232,24,90,0.2);
    animation: ai-float 3s ease-in-out infinite;
}
@keyframes ai-float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-6px); }
}
.ai-welcome-title {
    font-size: 18px;
    font-weight: 800;
    color: var(--ai-dark);
    margin-bottom: 6px;
}
.ai-welcome-sub {
    font-size: 13px;
    color: var(--ai-muted);
    line-height: 1.6;
    max-width: 380px;
}

/* ── Responsive ── */
@media (max-width: 768px) {
    .fp-page-chatbot {
        padding-bottom: 12px;
    }
    .ai-quick-wrap {
        overflow-x: auto;
        flex-wrap: nowrap;
        padding-bottom: 4px;
    }
    .ai-quick-btn {
        flex-shrink: 0;
    }
    .ai-msg {
        max-width: 92%;
    }
    .ai-typing-text {
        white-space: normal;
    }
}
</style>

<div class="ai-page">
    {{-- Header --}}
    <div class="fp-content-header">
        <div>
            <div class="fp-content-eyebrow">FloraPredict AI</div>
            <div class="fp-content-title">Asisten AI Prediksi Penjualan</div>
            <div class="fp-content-subtitle">Tanyakan ringkasan prediksi, stok rendah, dan data penjualan berdasarkan data sistem.</div>
        </div>
    </div>

    {{-- Quick Questions --}}
    <div class="ai-quick-wrap">
        <button type="button" class="ai-quick-btn" onclick="sendQuickQuestion(this)" data-question="Produk apa dengan prediksi tertinggi?">
            <span class="ai-quick-icon">📊</span>
            Produk prediksi tertinggi?
        </button>
        <button type="button" class="ai-quick-btn" onclick="sendQuickQuestion(this)" data-question="Berapa total prediksi pada periode aktif?">
            <span class="ai-quick-icon">📈</span>
            Total prediksi periode aktif?
        </button>
        <button type="button" class="ai-quick-btn" onclick="sendQuickQuestion(this)" data-question="Produk apa yang stoknya rendah?">
            <span class="ai-quick-icon">⚠️</span>
            Stok rendah?
        </button>
        <button type="button" class="ai-quick-btn" onclick="sendQuickQuestion(this)" data-question="Ringkas kondisi dashboard saat ini.">
            <span class="ai-quick-icon">🏠</span>
            Ringkasan dashboard
        </button>
    </div>

    {{-- Chat Container --}}
    <div class="ai-chat-container" data-state="ready">
        {{-- Chat Header --}}
        <div class="ai-chat-header">
            <div class="ai-chat-avatar">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2L13.09 9.26L20 12L13.09 14.74L12 22L10.91 14.74L4 12L10.91 9.26Z"/>
                </svg>
            </div>
            <div>
                <div class="ai-chat-info-name">Asisten FloraPredict</div>
                <div class="ai-chat-info-status">
                    <span class="ai-status-dot"></span>
                    <span id="ai-status-text">Siap menerima pertanyaan</span>
                </div>
            </div>
        </div>

        {{-- Messages --}}
        <div class="ai-messages" id="ai-messages">
            {{-- Welcome State (ditampilkan saat belum ada chat) --}}
            <div class="ai-welcome" id="ai-welcome">
                <div class="ai-welcome-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2L13.09 9.26L20 12L13.09 14.74L12 22L10.91 14.74L4 12L10.91 9.26Z"/>
                    </svg>
                </div>
                <div class="ai-welcome-title">Halo! Saya Asisten FloraPredict 👋</div>
                <div class="ai-welcome-sub">
                    Saya bisa membantu membaca data prediksi, mengecek stok rendah, dan meringkas kondisi penjualan. Pilih pertanyaan cepat di atas atau ketik pertanyaan Anda sendiri!
                </div>
            </div>
        </div>

        {{-- Input Area --}}
        <div class="ai-input-area">
            <div class="ai-input-wrap">
                <textarea
                    class="ai-input"
                    id="ai-input"
                    placeholder="Ketik pertanyaan tentang prediksi, stok, atau penjualan..."
                    rows="1"
                    maxlength="1000"
                ></textarea>
                <button type="button" class="ai-send-btn" id="ai-send-btn" onclick="sendMessage()" title="Kirim pesan" aria-label="Kirim pesan" disabled>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"/>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                    </svg>
                </button>
            </div>
            <div class="ai-input-hint">Tekan <strong>Enter</strong> untuk kirim · <strong>Shift+Enter</strong> untuk baris baru</div>
        </div>
    </div>
</div>

<script>
(function () {
    // ══════════════════════════════════════════
    // DOM Elements
    // ══════════════════════════════════════════
    const messagesEl   = document.getElementById('ai-messages');
    const welcomeEl    = document.getElementById('ai-welcome');
    const inputEl      = document.getElementById('ai-input');
    const sendBtn      = document.getElementById('ai-send-btn');
    const quickBtns    = document.querySelectorAll('.ai-quick-btn');
    const statusTextEl = document.getElementById('ai-status-text');
    const chatEl       = document.querySelector('.ai-chat-container');
    const csrfToken    = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let isLoading = false;
    let hasError = false;
    let lastFailedMessage = null;

    // ══════════════════════════════════════════
    // Auto-resize textarea
    // ══════════════════════════════════════════
    inputEl.addEventListener('input', function () {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 100) + 'px';
        updateSendState();
    });

    // ══════════════════════════════════════════
    // Keyboard: Enter to send, Shift+Enter for newline
    // ══════════════════════════════════════════
    inputEl.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    // ══════════════════════════════════════════
    // Helpers
    // ══════════════════════════════════════════
    function getTimeString() {
        const now = new Date();
        return now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    }

    function scrollToBottom() {
        requestAnimationFrame(() => {
            messagesEl.scrollTop = messagesEl.scrollHeight;
        });
    }

    function escapeHtml(text) {
        return String(text)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }

    function hideWelcome() {
        if (welcomeEl) {
            welcomeEl.style.display = 'none';
        }
    }

    function setStatus(text, state) {
        if (statusTextEl) {
            statusTextEl.textContent = text;
        }
        if (chatEl) {
            chatEl.dataset.state = state;
        }
    }

    function updateSendState() {
        sendBtn.disabled = isLoading || inputEl.value.trim().length === 0;
    }

    function setLoading(state) {
        isLoading = state;
        if (state) {
            hasError = false;
            setStatus('Sedang menganalisis pertanyaan...', 'loading');
        } else if (hasError) {
            setStatus('Respons belum berhasil dibuat', 'error');
        } else {
            setStatus('Siap menerima pertanyaan', 'ready');
        }

        updateSendState();
        inputEl.disabled = state;
        quickBtns.forEach(btn => {
            btn.disabled = state;
        });
        if (!state) inputEl.focus();
    }

    // ══════════════════════════════════════════
    // Add Message Bubble
    // ══════════════════════════════════════════
    function addMessage(text, type) {
        hideWelcome();

        const msgDiv = document.createElement('div');
        msgDiv.className = `ai-msg ${type}`;

        const avatarContent = type === 'bot'
            ? `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L13.09 9.26L20 12L13.09 14.74L12 22L10.91 14.74L4 12L10.91 9.26Z"/></svg>`
            : `{{ substr(Auth::user()->name ?? "A", 0, 1) }}`;

        // Sanitize text but preserve newlines
        const sanitized = escapeHtml(text)
            .replace(/\n/g, '<br>');

        msgDiv.innerHTML = `
            <div class="ai-msg-avatar">${avatarContent}</div>
            <div>
                <div class="ai-msg-bubble">${sanitized}</div>
                <div class="ai-msg-time">${getTimeString()}</div>
            </div>
        `;

        messagesEl.appendChild(msgDiv);
        scrollToBottom();
    }

    // ══════════════════════════════════════════
    // Typing Indicator
    // ══════════════════════════════════════════
    function showTyping() {
        const typingEl = document.createElement('div');
        typingEl.className = 'ai-typing';
        typingEl.id = 'ai-typing-indicator';
        typingEl.innerHTML = `
            <div class="ai-msg-avatar" style="background:linear-gradient(135deg,var(--ai-pk1),var(--ai-pk3));box-shadow:0 3px 10px rgba(232,24,90,0.15);">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L13.09 9.26L20 12L13.09 14.74L12 22L10.91 14.74L4 12L10.91 9.26Z"/></svg>
            </div>
            <div class="ai-typing-bubble" aria-label="Asisten sedang menganalisis">
                <div class="ai-typing-dots" aria-hidden="true">
                    <div class="ai-typing-dot"></div>
                    <div class="ai-typing-dot"></div>
                    <div class="ai-typing-dot"></div>
                </div>
                <div class="ai-typing-text">Menganalisis data...</div>
            </div>
        `;
        messagesEl.appendChild(typingEl);
        scrollToBottom();
    }

    function hideTyping() {
        const el = document.getElementById('ai-typing-indicator');
        if (el) el.remove();
    }

    // ══════════════════════════════════════════
    // Error Message
    // ══════════════════════════════════════════
    function showError(errorText) {
        hasError = true;
        setStatus('Respons belum berhasil dibuat', 'error');

        const errorDiv = document.createElement('div');
        errorDiv.className = 'ai-error';
        const safeErrorText = escapeHtml(errorText);
        errorDiv.innerHTML = `
            <div class="ai-error-icon">⚠️</div>
            <div style="flex:1">
                <div style="font-weight:700;margin-bottom:2px">Respons belum berhasil dibuat</div>
                <div style="font-size:11px;opacity:0.85">${safeErrorText}</div>
            </div>
            <button type="button" class="ai-error-retry" onclick="retryLastMessage(this)">Coba Lagi</button>
        `;
        messagesEl.appendChild(errorDiv);
        scrollToBottom();
    }

    // ══════════════════════════════════════════
    // Send Message
    // ══════════════════════════════════════════
    function clearErrors() {
        messagesEl.querySelectorAll('.ai-error').forEach(el => el.remove());
        hasError = false;
    }

    window.sendMessage = async function () {
        const message = inputEl.value.trim();
        if (!message || isLoading) return;

        // Clear input & reset height
        inputEl.value = '';
        inputEl.style.height = 'auto';
        updateSendState();

        await doSend(message);
    };

    window.sendQuickQuestion = function (btn) {
        const question = btn.getAttribute('data-question');
        if (!question || isLoading) return;
        doSend(question);
    };

    window.retryLastMessage = function (btn) {
        // Remove the error element
        const errorEl = btn.closest('.ai-error');
        if (errorEl) errorEl.remove();

        if (lastFailedMessage) {
            doSend(lastFailedMessage);
        }
    };

    async function doSend(message) {
        clearErrors();
        setLoading(true);
        lastFailedMessage = message;

        // Show user bubble
        addMessage(message, 'user');

        // Show typing
        showTyping();

        try {
            const response = await fetch('/api/chatbot/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ message: message }),
            });

            hideTyping();

            if (!response.ok) {
                const errData = await response.json().catch(() => null);
                const errMsg = errData?.message || `Server merespons dengan status ${response.status}`;
                showError(errMsg);
                setLoading(false);
                return;
            }

            const data = await response.json();

            // Ambil respons dari berbagai kemungkinan format
            const reply = data.reply
                || data.response
                || data.message
                || data.answer
                || data.text
                || (typeof data === 'string' ? data : null)
                || 'Maaf, saya tidak bisa memproses respons tersebut.';

            addMessage(reply, 'bot');
            lastFailedMessage = null;
            hasError = false;

        } catch (err) {
            hideTyping();
            showError('Koneksi ke Asisten AI belum tersedia. Periksa layanan chatbot atau coba lagi sebentar.');
        }

        setLoading(false);
    }

    updateSendState();
})();
</script>

</x-app-layout>
