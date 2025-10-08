panel.plugin('fr/quote-custom-block', {

  blocks: {
    quote: {
      template: `
      <div class="block-quote">
                <div class="text">
                    <div >
                      <k-input
                        v-bind="field('text')"
                        class="k-block-type-quote-text"
                        :value="content.text"
                        @input="update({ text: $event })">
                      </k-input>
                    </div>
                    <p>
                      <k-writer
                        v-bind="field('citation')"
                        :value="content.citation"
                        data-placeholder= "By .."
                        class="k-writer k-block-type-quote-citation"
                        @input="update({ citation: $event })">
                      </k-writer>
                    </p>
                  </div>
                  <div class="image">
                  <template v-if="content.image && content.image.length > 0">
                  <figure>
                  <k-figure
                    v-bind="field('thumb')"
                    :value="content.image && content.image[0] ? content.image[0].image.url : ''"
                    @input="update({ thumb: $event })"
                    class="k-block-type-image-auto"
                  ></k-figure>
                  <img 
                    :alt="content.image && content.image[0] && content.image[0].image.alt ? content.image[0].image.alt : 'Alternative Text Not Provided'"
                    :src="content.image && content.image[0] && typeof content.image[0].image.url != 'undefined' ? content.image[0].image.url : 'image not found'"
                    class="k-block-type-image-auto"
                  >
                  <figcaption v-if="content.image && content.image[0] && content.image[0].image.caption">{{ content.image[0].image.caption }}</figcaption>
                </figure>
            </div>
      </div>
      `
    }
  }
});
{/* <pre>{{ content | json }}</pre>  */ }
