import { toRaw } from 'vue';

export default function IsNotEmpty(object) {
    for (const key in object) {
        if (object[key] !== null) {
            return true;
        }
    }
    return false;
}

export function isNotEmptyPrefix(object, prefix) {
    const rawObj = toRaw(object);

    return Object.keys(rawObj).some(key =>
        Object.prototype.hasOwnProperty.call(rawObj, key) &&
        key.startsWith(prefix) &&
        rawObj[key] !== null
    );
}
