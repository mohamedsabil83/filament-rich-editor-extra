import { Extension } from '@tiptap/core'

// Sticky Toolbar is a purely client-side, UI-only feature — like Fullscreen it
// has no custom node or mark, so there is nothing to mirror on the server.
//
// Unlike the other tools it is not a toolbar button: it is opted in per editor
// with the `->stickyToolbar()` method, which adds a `data-sticky-toolbar`
// attribute to Filament's `.fi-fo-rich-editor` wrapper. This extension's only
// job is to inject (once) the CSS that makes the toolbar `position: sticky` for
// any wrapper carrying that attribute, so the toolbar stays pinned to the top
// of the viewport while a tall editor is scrolled past. For an editor that fits
// within the viewport sticky positioning is a no-op, so the toolbar only
// "follows" when the editor is taller than the view.

const STYLE_ID = 'fi-fo-rich-editor-sticky-toolbar-style'

// The toolbar is transparent by default, so we give it an opaque background
// while sticky to stop the scrolling content from showing through underneath.
// The z-index keeps it above the editor's own content (e.g. the floating
// toolbar at z-20) and surrounding page chrome, while staying below Filament
// modals (z-40) and notifications (z-50) so those still cover it.
function ensureStyles() {
    if (document.getElementById(STYLE_ID)) {
        return
    }

    const style = document.createElement('style')
    style.id = STYLE_ID
    style.textContent = `
        .fi-fo-rich-editor[data-sticky-toolbar] .fi-fo-rich-editor-toolbar {
            position: sticky;
            top: 0;
            z-index: 30;
            background-color: var(--bg-color, #fff);
        }

        .dark .fi-fo-rich-editor[data-sticky-toolbar] .fi-fo-rich-editor-toolbar {
            background-color: var(--bg-color, #1f2937);
        }
    `

    document.head.appendChild(style)
}

export default Extension.create({
    name: 'customStickyToolbar',

    onCreate() {
        ensureStyles()
    },
})
