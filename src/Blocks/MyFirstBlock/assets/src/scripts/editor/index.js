import { getBlockDefaultClassName, registerBlockType } from "@wordpress/blocks";
import { BaseControl, PanelBody } from "@wordpress/components";
import { InspectorControls, useBlockProps } from "@wordpress/block-editor";
import { _x } from "@wordpress/i18n";

import block_json from "../../../../block.json";
const { name } = block_json;

const classNameBase = getBlockDefaultClassName(name);

registerBlockType(name, {
    edit: props => {
        const { attributes, setAttributes } = props;
        const { url } = attributes;

        const blockProps = useBlockProps();
        return (
            <>
                <InspectorControls>
                    <PanelBody
                        title={_x(
                            "Block options",
                            "Panel Body title",
                            "PLUGIN_NAME"
                        )}
                        initialOpen={true}>
                        <BaseControl id={`${classNameBase}__urlfield`}>
                            <BaseControl.VisualLabel className='o-basecontrol__label'>
                                {_x(
                                    "iFrame URL",
                                    "Visual field label",
                                    "PLUGIN_NAME"
                                )}
                            </BaseControl.VisualLabel>
                            <input
                                type='url'
                                value={url}
                                className={`${classNameBase}__urlinput o-basecontrol__field`}
                                id={`${classNameBase}__urlfield`}
                                onChange={event =>
                                    setAttributes({ url: event.target.value })
                                }
                            />
                        </BaseControl>
                    </PanelBody>
                </InspectorControls>
                <div {...blockProps}>
                    {!!url && (
                        <iframe
                            className={`${classNameBase}__iframe`}
                            src={url}
                            allowtransparency='yes'
                            frameborder='0'
                            scrolling='no'></iframe>
                    )}
                    {!url && (
                        <p
                            className={`c-editormessage c-editormessage--warning`}
                            dangerouslySetInnerHTML={{
                                __html: _x(
                                    "There is no URL defined for this iframe.",
                                    "Block editor message",
                                    "PLUGIN_NAME"
                                ),
                            }}
                        />
                    )}
                </div>
            </>
        );
    },
});
