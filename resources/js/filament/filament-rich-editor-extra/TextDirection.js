import { Extension } from '@tiptap/core'

// Tiptap ships a native TextDirection extension inside @tiptap/core. It is always
// registered as a core extension by the editor, so its `setTextDirection` and
// `unsetTextDirection` commands (used by the toolbar buttons) are available out of
// the box — we no longer reimplement them here.
//
// That native extension only registers the `dir` global attribute when a global
// `direction` is configured on the editor, which Filament leaves unset. So this
// extension's sole job is to register the `dir` attribute on the relevant node
// types, giving the native commands somewhere to store the per-node direction.
export default Extension.create({
    name: 'customTextDirection',

    addOptions() {
        return {
            types: ['paragraph', 'heading'],
        }
    },

    addGlobalAttributes() {
        return [
            {
                types: this.options.types,
                attributes: {
                    dir: {
                        default: null,
                        parseHTML: element => element.getAttribute('dir'),
                        renderHTML: attributes => {
                            if (!attributes.dir) {
                                return {}
                            }

                            return {dir: attributes.dir}
                        },
                    },
                },
            },
        ]
    },
})
