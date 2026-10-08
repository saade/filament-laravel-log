import ace from 'ace-builds'
import 'ace-builds/src-noconflict/mode-ini'

export default ({
    maxLines,
    minLines,
    fontSize,
}) => ({
    /** @type {ace.Ace.Editor} */
    editor: null,

    listener: null,

    init() {
        this.editor = ace.edit(this.$refs.editor, {
            mode: 'ace/mode/ini',
            readOnly: true,
            maxLines,
            minLines,
            fontSize
        });

        this.listener = (event) => this.editor.session.setValue(event.detail.content)

        window.addEventListener('logContentUpdated', this.listener)
    },

    destroy() {
        window.removeEventListener('logContentUpdated', this.listener)

        this.editor.destroy()
    },

    jumpToEnd() {
        this.editor.gotoLine(this.editor.session.getLength())
    },

    jumpToStart() {
        this.editor.gotoLine(0)
    }
})
