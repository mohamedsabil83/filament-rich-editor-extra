import { Extension } from '@tiptap/core'

// Fullscreen is a purely client-side, UI-only feature — like Emoji it has no
// custom node or mark, so there is nothing to mirror on the server. The
// extension toggles a class on Filament's `.fi-fo-rich-editor` wrapper (which
// holds both the toolbar and the editable content) so the whole editor expands
// to fill the viewport.
//
// The active state is kept in the extension's storage and read by the toolbar
// button's `activeJsExpression`. After every toggle we dispatch an empty
// transaction so Filament re-evaluates that expression and the button reflects
// the current state.

const WRAPPER_SELECTOR = '.fi-fo-rich-editor'
const FULLSCREEN_CLASS = 'fi-fo-rich-editor-fullscreen'
const STYLE_ID = 'fi-fo-rich-editor-fullscreen-style'

// Inject the layout rules once. They make the wrapper cover the viewport and
// let the editable content area grow/scroll to fill the remaining space.
function ensureStyles() {
    if (document.getElementById(STYLE_ID)) {
        return
    }

    const style = document.createElement('style')
    style.id = STYLE_ID
    style.textContent = `
        .${FULLSCREEN_CLASS} {
            position: fixed !important;
            inset: 0 !important;
            z-index: 50 !important;
            margin: 0 !important;
            border-radius: 0 !important;
            display: flex !important;
            flex-direction: column !important;
            background-color: var(--bg-color, #fff);
        }

        .dark .${FULLSCREEN_CLASS} {
            background-color: var(--bg-color, #1f2937);
        }

        .${FULLSCREEN_CLASS} .fi-fo-rich-editor-main {
            flex: 1 1 auto;
            min-height: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .${FULLSCREEN_CLASS} .fi-fo-rich-editor-content {
            flex: 1 1 auto;
            min-height: 0;
            max-height: none;
            overflow-y: auto;
        }
    `

    document.head.appendChild(style)
}

function getWrapper(editor) {
    const dom = editor.view.dom

    return dom.closest(WRAPPER_SELECTOR) ?? dom.parentElement ?? dom
}

export default Extension.create({
    name: 'customFullscreen',

    addStorage() {
        return {
            active: false,
            // Removes the global keydown listener when leaving fullscreen.
            cleanup: null,
        }
    },

    addCommands() {
        return {
            setFullscreen:
                () =>
                ({ editor }) => {
                    if (this.storage.active) {
                        return false
                    }

                    ensureStyles()

                    const wrapper = getWrapper(editor)
                    wrapper.classList.add(FULLSCREEN_CLASS)

                    const onKeyDown = (event) => {
                        if (event.key === 'Escape') {
                            editor.commands.unsetFullscreen()
                        }
                    }
                    document.addEventListener('keydown', onKeyDown, true)

                    this.storage.active = true
                    this.storage.cleanup = () => {
                        document.removeEventListener('keydown', onKeyDown, true)
                    }

                    // Force Filament to re-evaluate the button's active state.
                    editor.view.dispatch(editor.state.tr)

                    return true
                },

            unsetFullscreen:
                () =>
                ({ editor }) => {
                    if (!this.storage.active) {
                        return false
                    }

                    getWrapper(editor).classList.remove(FULLSCREEN_CLASS)

                    this.storage.cleanup?.()
                    this.storage.cleanup = null
                    this.storage.active = false

                    editor.view.dispatch(editor.state.tr)

                    return true
                },

            toggleFullscreen:
                () =>
                ({ editor }) =>
                    this.storage.active
                        ? editor.commands.unsetFullscreen()
                        : editor.commands.setFullscreen(),
        }
    },

    onDestroy() {
        this.storage.cleanup?.()
    },
})