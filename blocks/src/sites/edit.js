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
import { useBlockProps } from "@wordpress/block-editor";

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
export default function Edit({ attributes, setAttributes }) {
  const blockProps = useBlockProps();

  return (
    <div {...blockProps}>
      <div class="controls">
        <i class="fa-solid fa-plus"></i>
        <p>New Site</p>
        <i class="fa-solid fa-arrows-up-down"></i>
        <i class="fa-solid fa-trash"></i>
      </div>
      <ul id="sites-list">
        <li>
          <i class="fa-solid fa-location-dot"></i>
          <div>
            <h3>Houston Branch</h3>
            <p>49 ABC Parkway Beloit, WI 53511 …</p>
          </div>
          <i class="fa-solid fa-angle-right"></i>
        </li>
        <li>
          <i class="fa-solid fa-location-dot"></i>
          <div>
            <h3>Dallas Branch</h3>
            <p>4833 Singleton Boulevard, Eagle Ford, Dallas …</p>
          </div>
          <i class="fa-solid fa-angle-right"></i>
        </li>
        <li>
          <i class="fa-solid fa-location-dot"></i>
          <div>
            <h3>Portland Branch</h3>
            <p>1810 Southeast 10th Avenue, Portland, OR …</p>
          </div>
          <i class="fa-solid fa-angle-right"></i>
        </li>
        <li>
          <i class="fa-solid fa-location-dot"></i>
          <div>
            <h3>Chico Branch</h3>
            <p>1205 West 7th Street, Chico, CA 95928</p>
          </div>
          <i class="fa-solid fa-angle-right"></i>
        </li>
        <li class="selected">
          <i class="fa-solid fa-location-dot"></i>
          <div>
            <h3>Freeport Branch</h3>
            <p>247 East Park Street, Freeport, IL 61032</p>
          </div>
          <i class="fa-solid fa-angle-right"></i>
        </li>
        <li>
          <i class="fa-solid fa-location-dot"></i>
          <div>
            <h3>Emerald Isle Branch</h3>
            <p>300 West, Murray, UT 84107</p>
          </div>
          <i class="fa-solid fa-angle-right"></i>
        </li>
        <li>
          <i class="fa-solid fa-location-dot"></i>
          <div>
            <h3>Caledonia Branch</h3>
            <p>7195 Greenlee Road, Caledonia, IL 61011</p>
          </div>
          <i class="fa-solid fa-angle-right"></i>
        </li>
        <li>
          <i class="fa-solid fa-location-dot"></i>
          <div>
            <h3>Benwood Branch</h3>
            <p>49 ABC Parkway Beloit, WI 53511…</p>
          </div>
          <i class="fa-solid fa-angle-right"></i>
        </li>
      </ul>
    </div>
  );
}
