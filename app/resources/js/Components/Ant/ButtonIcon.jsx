// ButtonIcon.jsx
import { Button, Tooltip } from 'antd';
import { PencilIcon, TrashIcon } from '@heroicons/react/24/outline';

export const Icons = { Pencil: PencilIcon, Trash: TrashIcon };


export default function ButtonIcon({ iconName, tooltip, ...props }) {
    const IconComp = Icons[iconName];
    return ( 
        <Tooltip title={tooltip}>
            <Button icon={IconComp ? <IconComp className="h-5 w-5" /> : null} {...props} />
        </Tooltip>
    );
}
