import { usePages } from "../helpers";
/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { InspectorControls, useBlockProps } from "@wordpress/block-editor";
import { PanelBody, SelectControl, Spinner } from "@wordpress/components";
/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @param {Object}   props               Properties passed to the function.
 * @param {Object}   props.attributes    Available block attributes.
 * @param {Function} props.setAttributes Function that updates individual attributes.
 *
 * @return {Element} Element to render.
 */
export default function Edit(props) {
  const { attributes, setAttributes } = props;
  const { pages, hasResolved } = usePages(props);
  const options = pages
    ? pages.map((p) => {
        return { value: p.id, label: p.title.raw };
      })
    : [];
  options.unshift({ value: "none", label: "Select a Page" });

  const { backPage } = attributes;

  const blockProps = useBlockProps();

  return (
    <div {...blockProps}>
      <InspectorControls>
        <PanelBody title="Settings" initialOpen={true}>
          {hasResolved ? (
            <>
              <SelectControl
                label="Go back to page"
                value={parseInt(backPage) > 0 ? backPage : "none"}
                options={options}
                onChange={(value) => {
                  setAttributes({ backPage: value });
                }}
              />
            </>
          ) : (
            <div style={{ marginBottom: "10px" }}>
              Loading Pages
              <Spinner />
            </div>
          )}
        </PanelBody>
      </InspectorControls>
      <i class="fa-solid fa-angle-left"></i>Back Button
    </div>
  );
}
