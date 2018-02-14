import { Pipe } from '@angular/core';

@Pipe({
  name: 'reverse',
  pure: false
})
export class ReversePipe {
  
transform (values) {
	console.log(values);
    return values.reverse();
  }
}