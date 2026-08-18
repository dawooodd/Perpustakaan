{{-- Comment Section Component --}}
{{-- Expects $book variable --}}
<div x-data="commentSection({{ $book->id }})" x-init="loadComments()" class="mt-8">
    <h3 class="text-lg font-display font-bold text-surface-900 dark:text-white mb-6 flex items-center gap-2">
        <i data-lucide="message-circle" class="w-5 h-5 text-primary-500"></i>
        Komentar
        <span class="text-sm font-normal text-surface-400" x-text="'(' + comments.length + ')'"></span>
    </h3>

    {{-- Comment Form --}}
    @auth
    <div class="mb-8">
        <div class="flex gap-3">
            <div class="avatar avatar-sm shrink-0 mt-1">{{ Auth::user()->initials }}</div>
            <div class="flex-1">
                <textarea x-model="newComment"
                          rows="3"
                          placeholder="Tulis komentar..."
                          class="form-input text-sm resize-none"
                          @keydown.meta.enter="submitComment()"
                          @keydown.ctrl.enter="submitComment()"></textarea>
                <div class="flex items-center justify-between mt-2">
                    <span class="text-xs text-surface-400">Ctrl + Enter untuk kirim</span>
                    <button @click="submitComment()"
                            :disabled="!newComment.trim() || submitting"
                            class="btn-primary btn-sm">
                        <i data-lucide="send" class="w-3.5 h-3.5"></i>
                        <span x-text="submitting ? 'Mengirim...' : 'Kirim'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endauth

    @guest
    <div class="mb-8 p-4 rounded-xl bg-surface-50 dark:bg-surface-800 border border-surface-200 dark:border-surface-700 text-center">
        <p class="text-sm text-surface-500 dark:text-surface-400 mb-3">
            <i data-lucide="message-circle" class="w-4 h-4 inline -mt-0.5"></i>
            Masuk untuk meninggalkan komentar
        </p>
        <a href="{{ route('login') }}" class="btn-primary btn-sm">
            <i data-lucide="log-in" class="w-3.5 h-3.5"></i> Masuk
        </a>
    </div>
    @endguest

    {{-- Comments List --}}
    <div class="space-y-1">
        <template x-for="comment in comments" :key="comment.id">
            <div class="comment-card">
                <div class="avatar avatar-sm shrink-0 mt-0.5" x-text="comment.user_initials"></div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-sm font-semibold text-surface-800 dark:text-surface-200" x-text="comment.user_name"></span>
                        <span class="text-xs text-surface-400" x-text="comment.created_at"></span>
                    </div>
                    <p class="text-sm text-surface-600 dark:text-surface-300 leading-relaxed" x-text="comment.body"></p>

                    {{-- Reply toggle --}}
                    @auth
                    <button @click="comment.showReplyForm = !comment.showReplyForm"
                            class="text-xs text-primary-600 dark:text-primary-400 hover:underline mt-2 flex items-center gap-1">
                        <i data-lucide="reply" class="w-3 h-3"></i> Balas
                    </button>

                    {{-- Reply Form --}}
                    <div x-show="comment.showReplyForm" x-transition class="mt-3 pl-2" style="display:none;">
                        <div class="flex gap-2">
                            <textarea x-model="comment.replyText" rows="2" placeholder="Tulis balasan..."
                                      class="form-input text-xs resize-none flex-1"></textarea>
                            <button @click="submitReply(comment)"
                                    :disabled="!comment.replyText?.trim()"
                                    class="btn-primary btn-sm shrink-0 self-end">
                                <i data-lucide="send" class="w-3 h-3"></i>
                            </button>
                        </div>
                    </div>
                    @endauth

                    {{-- Replies --}}
                    <template x-for="reply in comment.replies" :key="reply.id">
                        <div class="comment-card mt-2 ml-4 bg-surface-50/50 dark:bg-surface-700/20 rounded-lg">
                            <div class="avatar avatar-sm shrink-0 mt-0.5 text-[10px]" x-text="reply.user_initials"></div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs font-semibold text-surface-800 dark:text-surface-200" x-text="reply.user_name"></span>
                                    <span class="text-[10px] text-surface-400" x-text="reply.created_at"></span>
                                </div>
                                <p class="text-xs text-surface-600 dark:text-surface-300 leading-relaxed" x-text="reply.body"></p>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </template>

        {{-- Empty state --}}
        <div x-show="comments.length === 0 && !loading" class="text-center py-8">
            <i data-lucide="message-circle" class="w-10 h-10 mx-auto text-surface-300 dark:text-surface-600 mb-3"></i>
            <p class="text-sm text-surface-400 dark:text-surface-500">Belum ada komentar. Jadilah yang pertama!</p>
        </div>

        {{-- Loading --}}
        <div x-show="loading" class="text-center py-8">
            <div class="w-6 h-6 border-2 border-primary-500 border-t-transparent rounded-full animate-spin mx-auto"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function commentSection(bookId) {
    return {
        bookId: bookId,
        comments: [],
        newComment: '',
        submitting: false,
        loading: true,

        async loadComments() {
            try {
                const res = await fetch(`/books/${this.bookId}/comments`);
                const data = await res.json();
                this.comments = data.comments.map(c => ({
                    ...c,
                    showReplyForm: false,
                    replyText: '',
                }));
            } catch (e) {
                console.error('Failed to load comments:', e);
            } finally {
                this.loading = false;
            }
        },

        async submitComment() {
            if (!this.newComment.trim() || this.submitting) return;
            this.submitting = true;
            try {
                const res = await fetch(`/books/${this.bookId}/comment`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ body: this.newComment }),
                });
                const data = await res.json();
                if (data.status === 'ok') {
                    this.comments.unshift({
                        ...data.comment,
                        replies: [],
                        showReplyForm: false,
                        replyText: '',
                    });
                    this.newComment = '';
                }
            } catch (e) {
                console.error('Failed to submit comment:', e);
            } finally {
                this.submitting = false;
                this.$nextTick(() => { if(window.lucide) lucide.createIcons(); });
            }
        },

        async submitReply(comment) {
            if (!comment.replyText?.trim()) return;
            try {
                const res = await fetch(`/books/${this.bookId}/comment`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ body: comment.replyText, parent_id: comment.id }),
                });
                const data = await res.json();
                if (data.status === 'ok') {
                    comment.replies.push(data.comment);
                    comment.replyText = '';
                    comment.showReplyForm = false;
                }
            } catch (e) {
                console.error('Failed to submit reply:', e);
            }
        },
    };
}
</script>
@endpush
