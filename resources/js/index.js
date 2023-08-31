import ace from 'ace-builds'
import 'ace-builds/src-noconflict/mode-ini'

export default ({
    maxLines,
    minLines,
    fontSize,
}) => ({
    /** @type {ace.Ace.Editor} */
    editor: null,

    init() {
        this.editor = ace.edit(this.$refs.editor, {
            mode: 'ace/mode/ini',
            readOnly: true,
            maxLines,
            minLines,
            fontSize
        });

        window.addEventListener('logContentUpdated', e => {
            this.editor.session.setValue(e.detail.content)
        })
    },

    jumpToEnd() {
        this.editor.gotoLine(this.editor.session.doc.$lines.length)
    },

    jumpToStart() {
        this.editor.gotoLine(0)
    }
})
