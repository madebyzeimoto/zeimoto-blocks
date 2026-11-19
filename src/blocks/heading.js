// ==========================================================
// Plugins :: zeimoto :: Blocks :: Panel :: Heading
// ==========================================================
//
// Marks fixed toolbars for layout while retaining native heading behavior.
//
// ==========================================================

export default {
  extends: "k-block-type-heading",
  render(h) {
    return h("div", {
      class: ["k-block-type-heading-input", this.$attrs.class, { "zeimoto-blocks-heading-fixed": this.textField.toolbar?.inline === false }],
      style: this.$attrs.style,
      attrs: { "data-level": this.content.level },
    }, [
      h("k-writer-input", {
        ref: "input",
        attrs: { ...this.textField, disabled: this.disabled, inline: true, keys: this.keys, value: this.content.text },
        on: { input: (value) => this.update({ text: value }) },
      }),
      this.levels.length > 1 ? h("k-input", {
        ref: "level",
        class: "k-block-type-heading-level",
        attrs: { disabled: this.disabled, empty: false, options: this.levels, value: this.content.level, type: "select" },
        on: { input: (value) => this.update({ level: value }) },
      }) : null,
    ])
  },
}
