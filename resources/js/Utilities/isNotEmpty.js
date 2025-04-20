export default function IsNotEmpty(object) {
    for (const key in object) {
        if (object[key] !== null) {
            return true;
        }
    }
    return false;
}

export function isNotEmptyPrefix(object, prefix) {
    return Object.keys(object).some(key => key.startsWith(prefix));
}
