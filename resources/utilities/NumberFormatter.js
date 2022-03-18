class NumberFormatter {
  // #PRECISION = 2;

  static parseNumber(n) {
    return Number(n);
  }

  static isANumber(n){
    return isNaN(n);
  }

  static noGreaterThan16Percent(n){
    let deci = NumberFormatter.parseNumber(n);
    return !(deci > 16 || deci < 0);
  }

  static isEmpty(n) {
    return (n.length === 0);
  }

  static parseNumberFromStringWithTwoDecimalPrecision (n) {
    return Number((n).toFixed(2))
  }

  static convertToStringAndAddDecimal(_number) {
    let formatToString = _number.toString();
    let formatToCurrency = (formatToString.includes('.')) ? formatToString : formatToString+='.00';
    return formatToCurrency.replace(/\d(?=(\d{3})+\.)/g, '$&,');
  }




}

export default NumberFormatter;
